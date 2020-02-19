<?php

    use Illuminate\Database\Seeder;
    use Illuminate\Support\Str;

    class UsersTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            $data = [
                [
                    'id' => 1,
                    'name' => 'admin',
                    'email' => 'a@a.ua',
                    'password' => bcrypt(12345678),
                ],
                [
                    'id' => 2,
                    'name' => 'user',
                    'email' => 'u@u.ua',
                    'password' => bcrypt(12345678),
                ],
                [
                    'id' => 3,
                    'name' => 'vetkharkov',
                    'email' => 'admin@admin.ua',
                    'password' => bcrypt(12345678),
                ],
                [
                    'id' => 4,
                    'name' => 'Masha',
                    'email' => 'admin@admin.ua9',
                    'password' => bcrypt(12345678),
                ],
                [
                    'id' => 5,
                    'name' => 'Pasha',
                    'email' => 'admin@admin.ua10',
                    'password' => bcrypt(12345678),
                ],
                [
                    'id' => 6,
                    'name' => 'Misha',
                    'email' => 'admin@admin.ua11',
                    'password' => bcrypt(12345678),
                ],
                [
                    'id' => 7,
                    'name' => 'Dasha',
                    'email' => 'admin@admin.ua12',
                    'password' => bcrypt(12345678),
                ],
                [
                    'id' => 8,
                    'name' => 'Olia',
                    'email' => 'admin@admin.ua13',
                    'password' => bcrypt(12345678),
                ],
                [
                    'id' => 9,
                    'name' => 'Kolia',
                    'email' => 'admin@admin.ua14',
                    'password' => bcrypt(12345678),
                ],
                [
                    'id' => 10,
                    'name' => 'Oleg',
                    'email' => 'admin@admin.ua15',
                    'password' => bcrypt(12345678),
                ],
                [
                    'id' => 11,
                    'name' => 'Ira',
                    'email' => 'admin@admin.ua16',
                    'password' => bcrypt(12345678),
                ],
                [
                    'id' => 12,
                    'name' => 'Nastia',
                    'email' => 'admin@admin.ua17',
                    'password' => bcrypt(12345678),
                ],
            ];
            DB::table('users')->insert($data);
        }

    }
