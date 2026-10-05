<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BoardMember;

class BoardMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = [
            ['name' => 'Handoko S.Pd.I', 'position' => 'Dewan Pendiri'],
            ['name' => 'H. Agung Nugroho, S.E, M.M', 'position' => 'Ketua Dewan Pembina'],
            ['name' => 'H. Ayat Cahyadi S.Si M.PWK', 'position' => 'Dewan Pembina'],
            ['name' => 'H. Markarius Anwar, S.T, M. Arch', 'position' => 'Dewan Pembina'],
            ['name' => 'Ali Imron', 'position' => 'Dewan Pembina'],
            ['name' => 'Itang Tarsana', 'position' => 'Dewan Pembina'],
            ['name' => 'Ibrahim', 'position' => 'Dewan Pembina'],
            ['name' => 'Lazwardi Rosyad', 'position' => 'Dewan Pembina'],
            ['name' => 'Erman Sari', 'position' => 'Dewan Pembina'],
            ['name' => 'Handoko S.Pd.I', 'position' => 'Ketua Umum'],
            ['name' => 'Adi Yuski', 'position' => 'Sekretaris Umum'],
            ['name' => 'Fits Bettiyandi, S.E', 'position' => 'Bendahara Umum'],
            ['name' => 'Suci Damaiyanti, S.E', 'position' => 'Wakil Bendahara Umum'],
            ['name' => 'Ahmad Rijal Dakhyu', 'position' => 'Divisi Pengawas Organisasi'],
            ['name' => 'Siska Afriani Sundari', 'position' => 'Divisi Sponsorship & EO'],
            ['name' => 'Lila Nofrianti', 'position' => 'Divisi Media'],
            ['name' => 'Edy Purwanto', 'position' => 'Divisi Digital Marketing'],
            ['name' => 'Abdul Syarif, S.H, M.H', 'position' => 'Divisi Hukum'],
            ['name' => 'Syafriance', 'position' => 'Divisi Sekretariat & Perlengkapan'],
        ];

        foreach ($members as $index => $member) {
            BoardMember::create([
                'name' => $member['name'],
                'position' => $member['position'],
                'order' => $index + 1,
            ]);
        }
    }
}
