<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Client;
use App\Models\Warehouse;
use App\Models\TransferType;
use Illuminate\Support\Str;

class CodingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
                
        TransferType::create(['name' => 'المشتريات']);
        TransferType::create(['name' => 'نقل']);
        TransferType::create(['name' => 'تكوين سلعى']);
        TransferType::create(['name' => 'مردودات مشتريات']);
        TransferType::create(['name' => 'مبيعات']);
        TransferType::create(['name' => 'اهلاك']);
        

        Category::create(['slug' => Str::slug('اخرى'),'name' => 'اخرى']);
        Category::create(['slug' => Str::slug('ادوات كهربائية'),'name' => 'ادوات كهربائية']);
        Category::create(['slug' => Str::slug('امن صناعي'),'name' => 'امن صناعي']);
        Category::create(['slug' => Str::slug('جودة'),'name' => 'جودة']);
        Category::create(['slug' => Str::slug('عدة تركيب ميكانيكا'),'name' => 'عدة تركيب ميكانيكا']);
        Category::create(['slug' => Str::slug('عدة رباط وتخريم'),'name' => 'عدة رباط وتخريم']);
        Category::create(['slug' => Str::slug('عدة رفع'),'name' => 'عدة رفع']);
        Category::create(['slug' => Str::slug('عدة سقالات'),'name' => 'عدة سقالات']);
        Category::create(['slug' => Str::slug('عدة لحام'),'name' => 'عدة لحام']);
        Category::create(['slug' => Str::slug('عدة مدنى'),'name' => 'عدة مدنى']);
        Category::create(['slug' => Str::slug('عدة يدوية'),'name' => 'عدة يدوية']);
        Category::create(['slug' => Str::slug('كابلات كهربائية'),'name' => 'كابلات كهربائية']);
        Category::create(['slug' => Str::slug('كرفانات و كونتينر'),'name' => 'كرفانات و كونتينر']);
        Category::create(['slug' => Str::slug('مساحة'),'name' => 'مساحة']);
        Category::create(['slug' => Str::slug('مستلزمات سباكة'),'name' => 'مستلزمات سباكة']);
        Category::create(['slug' => Str::slug('مستهلكات وخامات'),'name' => 'مستهلكات وخامات']);
        Category::create(['slug' => Str::slug('معدات ثقيلة'),'name' => 'معدات ثقيلة']);
        Category::create(['slug' => Str::slug('مهمات مكتبية'),'name' => 'مهمات مكتبية']);

        Unit::create(['slug' => Str::slug('عدد'),'name' => 'عدد']);
        Unit::create(['slug' => Str::slug('كيلو'),'name' => 'كيلو']);
        Unit::create(['slug' => Str::slug('م.ط'),'name' => 'م.ط']);
        Unit::create(['slug' => Str::slug('لفة'),'name' => 'لفة']);
        Unit::create(['slug' => Str::slug('شريط'),'name' => 'شريط']);
        Unit::create(['slug' => Str::slug('علبة'),'name' => 'علبة']);
        Unit::create(['slug' => Str::slug('لتر'),'name' => 'لتر']);

        Client::create(['slug' => Str::slug('غير معروف'),'name' => 'غير معروف']);
        Warehouse::create(['slug' => Str::slug('مخزن رئيسى'),'name' => 'مخزن رئيسى']);
        Warehouse::create(['slug' => Str::slug('مخزن الخشب'),'name' => 'مخزن الخشب']);
        Warehouse::create(['slug' => Str::slug('مخزن الحديد'),'name' => 'مخزن الحديد']);
        Warehouse::create(['slug' => Str::slug('مخزن العلمين'),'name' => 'مخزن العلمين']);
        Warehouse::create(['slug' => Str::slug('مخزن ورشه احمد ماهر'),'name' => 'مخزن ورشه احمد ماهر']);
        Warehouse::create(['slug' => Str::slug('م- عاطف'),'name' => 'م- عاطف']);
        Warehouse::create(['slug' => Str::slug('مخزن المعدات'),'name' => 'مخزن المعدات']);
        Warehouse::create(['slug' => Str::slug('الادارة'),'name' => 'الادارة']);
    }
}
