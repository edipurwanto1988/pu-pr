<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BoardMember;
use Illuminate\Http\Request;
use App\Services\GoogleDriveService;

class BoardMemberController extends Controller
{
    public function index()
    {
        $members = BoardMember::orderBy('order')->get();
        return view('admin.board-members.index', compact('members'));
    }

    public function create()
    {
        return view('admin.board-members.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'position']);

        if ($request->hasFile('photo')) {
            $driveId = GoogleDriveService::upload($request->file('photo'), 'Board_');
            if ($driveId) {
                $data['photo_id'] = 'gdrive:' . $driveId;
            } else {
                return back()->withInput()->with('error', 'Gagal mengupload foto ke Google Drive. Pastikan pengaturan terkonfigurasi dengan benar.');
            }
        }

        $data['order'] = BoardMember::max('order') + 1;
        BoardMember::create($data);

        return redirect()->route('admin.board-members.index')->with('success', 'Anggota Dewan Pengurus berhasil ditambahkan.');
    }

    public function edit(BoardMember $boardMember)
    {
        return view('admin.board-members.edit', compact('boardMember'));
    }

    public function update(Request $request, BoardMember $boardMember)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'position']);

        if ($request->hasFile('photo')) {
            $driveId = GoogleDriveService::upload($request->file('photo'), 'Board_');
            if ($driveId) {
                $data['photo_id'] = 'gdrive:' . $driveId;
            } else {
                return back()->withInput()->with('error', 'Gagal mengupload foto ke Google Drive.');
            }
        }

        $boardMember->update($data);

        return redirect()->route('admin.board-members.index')->with('success', 'Anggota Dewan Pengurus berhasil diperbarui.');
    }

    public function destroy(BoardMember $boardMember)
    {
        $boardMember->delete();
        return redirect()->route('admin.board-members.index')->with('success', 'Anggota Dewan Pengurus berhasil dihapus.');
    }

    public function reorder(Request $request)
    {
        $order = $request->input('order');
        if (is_array($order)) {
            foreach ($order as $index => $id) {
                BoardMember::where('id', $id)->update(['order' => $index]);
            }
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 400);
    }
}
