<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Models\User;
use App\Models\UmkmProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UmkmController extends Controller
{
    public function index(Request $request)
    {
        $query = UmkmProfile::with('user', 'kecamatan', 'kelurahan');

        if (auth()->user()->hasRole('umkm-ikm')) {
            $query->where('user_id', auth()->id());
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('business_name', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('kecamatan_id')) {
            $query->where('kecamatan_id', $request->kecamatan_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $umkm = $query->orderBy('created_at', 'desc')->paginate(15);
        $kecamatans = Kecamatan::orderBy('name')->get();

        return view('admin.umkm.index', compact('umkm', 'kecamatans'));
    }

    public function create()
    {
        if (auth()->user()->hasRole('umkm-ikm')) {
            $count = UmkmProfile::where('user_id', auth()->id())->count();
            if ($count >= 3) {
                return redirect()->route('admin.umkm.index')->with('error', 'Anda hanya dapat membuat maksimal 3 data UMKM/IKM.');
            }
        }

        $existingUserIds = UmkmProfile::pluck('user_id')->toArray();
        $users = User::whereNotIn('id', $existingUserIds)->orderBy('name')->get();
        $kecamatans = Kecamatan::with('kelurahans')->orderBy('name')->get();
        return view('admin.umkm.create', compact('users', 'kecamatans'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->hasRole('umkm-ikm')) {
            $count = UmkmProfile::where('user_id', auth()->id())->count();
            if ($count >= 3) {
                return redirect()->route('admin.umkm.index')->with('error', 'Anda hanya dapat membuat maksimal 3 data UMKM/IKM.');
            }
        }

        if (auth()->user()->hasRole('umkm-ikm')) {
            $request->merge(['user_source' => 'existing', 'user_id' => auth()->id()]);
        }

        $request->validate([
            'user_source' => 'required|in:existing,new',
            'user_id' => 'required_if:user_source,existing|nullable|exists:users,id',
            'name' => 'required_if:user_source,new|nullable|string|max:255',
            'email' => 'required_if:user_source,new|nullable|email|max:255|unique:users,email',
            'password' => 'required_if:user_source,new|nullable|string|min:8',
            'business_name' => 'required|string|max:255',
            'business_type' => 'required|in:produk,jasa',
            'type' => 'required|in:umkm,ikm',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'kecamatan_id' => 'nullable|exists:kecamatans,id',
            'kelurahan_id' => 'nullable|exists:kelurahans,id',
            'postal_code' => 'nullable|string|max:10',
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'status' => 'required|in:pending,approved',
        ]);

        if ($request->user_source === 'new') {
            $umkmRole = \App\Models\Role::where('slug', 'umkm')->first();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $umkmRole?->id,
                'status' => 'active',
            ]);
        } else {
            $request->validate([
                'user_id' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        if (UmkmProfile::where('user_id', $value)->exists()) {
                            $fail('User ini sudah memiliki profil UMKM.');
                        }
                    },
                ],
            ]);
            $user = User::find($request->user_id);
        }

        UmkmProfile::create([
            'user_id' => $user->id,
            'business_name' => $request->business_name,
            'business_type' => $request->business_type,
            'type' => $request->type,
            'slug' => Str::slug($request->business_name),
            'description' => $this->cleanTinyMce($request->description),
            'address' => $request->address,
            'kecamatan_id' => $request->kecamatan_id,
            'kelurahan_id' => $request->kelurahan_id,
            'postal_code' => $request->postal_code,
            'phone' => $request->phone,
            'whatsapp' => $request->whatsapp,
            'status' => $request->status,
            'validated_by' => $request->status === 'approved' ? auth()->id() : null,
            'validated_at' => $request->status === 'approved' ? now() : null,
        ]);

        return redirect()->route('admin.umkm.index')->with('success', 'UMKM/IKM berhasil dibuat');
    }

    public function show(UmkmProfile $umkm)
    {
        $umkm->load('kecamatan', 'kelurahan');
        return view('admin.umkm.show', compact('umkm'));
    }

    public function edit(UmkmProfile $umkm)
    {
        $kecamatans = Kecamatan::with('kelurahans')->orderBy('name')->get();
        return view('admin.umkm.edit', compact('umkm', 'kecamatans'));
    }

    public function update(Request $request, UmkmProfile $umkm)
    {
        $request->validate([
            'business_name' => 'required|string|max:255',
            'business_type' => 'required|in:produk,jasa',
            'type' => 'required|in:umkm,ikm',
            'kecamatan_id' => 'nullable|exists:kecamatans,id',
            'kelurahan_id' => 'nullable|exists:kelurahans,id',
        ]);

        $data = $request->only(['business_name', 'business_type', 'type', 'description', 'address', 'kecamatan_id', 'kelurahan_id', 'postal_code', 'phone', 'whatsapp']);
        $data['slug'] = \Str::slug($request->business_name);
        $data['description'] = $this->cleanTinyMce($data['description'] ?? null);

        $umkm->update($data);

        return redirect()->route('admin.umkm.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(UmkmProfile $umkm)
    {
        $umkm->user->delete();
        $umkm->delete();
        return redirect()->route('admin.umkm.index')->with('success', 'UMKM/IKM berhasil dihapus');
    }

    public function approve(UmkmProfile $umkm)
    {
        $umkm->update([
            'status' => 'approved',
            'validated_by' => auth()->id(),
            'validated_at' => now(),
        ]);
        return redirect()->route('admin.umkm.index')->with('success', 'UMKM/IKM telah disetujui');
    }

    public function reject(Request $request, UmkmProfile $umkm)
    {
        $request->validate(['rejection_reason' => 'required|string']);
        
        $umkm->update([
            'status' => 'rejected',
            'validated_by' => auth()->id(),
            'validated_at' => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);
        return redirect()->route('admin.umkm.index')->with('success', 'UMKM/IKM ditolak');
    }

    public function kelurahanByKecamatan($kecamatanId)
    {
        $kelurahans = \App\Models\Kelurahan::where('kecamatan_id', $kecamatanId)->orderBy('name')->get();
        return response()->json($kelurahans);
    }

    private function cleanTinyMce(?string $content): ?string
    {
        if (!$content) return null;
        $stripped = trim(strip_tags($content));
        return $stripped === '' ? null : $content;
    }
}