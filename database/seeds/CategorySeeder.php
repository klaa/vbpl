<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cats = [
            [
                'name'          => 'Đào tạo và Tuyển sinh',
                'alias'         => 'dao-tao-va-tuyen-sinh',
                'category_type' => 'post'
            ],
            [
                'name'          => 'Người học',
                'alias'         => 'nguoi-hoc',
                'category_type' => 'post'
            ],
            [
                'name'          => 'TCCB, TL, BH',
                'alias'         => 'tccb-tl-bh',
                'category_type' => 'post'
            ],
            [
                'name'          => 'Hành chính',
                'alias'         => 'hanh-chinh',
                'category_type' => 'post'
            ],
            [
                'name'          => 'SHTT',
                'alias'         => 'shtt',
                'category_type' => 'post'
            ],
            [
                'name'          => 'Khoa học và Công nghệ',
                'alias'         => 'khoa-hoc-va-cong-nghe',
                'category_type' => 'post'
            ],
            [
                'name'          => 'Hợp tác quốc tế',
                'alias'         => 'hop-tac-quoc-te',
                'category_type' => 'post'
            ],
            [
                'name'          => 'ĐBCL',
                'alias'         => 'dbcl',
                'category_type' => 'post'
            ],
            [
                'name'          => 'Văn bản chung',
                'alias'         => 'van-ban-chung',
                'category_type' => 'post'
            ],
            [
                'name'          => 'Tự chủ',
                'alias'         => 'tu-chu',
                'category_type' => 'post'
            ],
            [
                'name'          => 'KN_TC',
                'alias'         => 'nk-tc',
                'category_type' => 'post'
            ],
        ];
        foreach ($cats as $key => $value) {
            $cat = new Category($value);
            $cat->save();
        }         
    }
}
