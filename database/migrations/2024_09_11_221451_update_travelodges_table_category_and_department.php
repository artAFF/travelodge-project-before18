<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('travelodges', function (Blueprint $table) {
            // เพิ่มคอลัมน์ใหม่
            $table->unsignedBigInteger('category_id')->after('id')->nullable();
            $table->unsignedBigInteger('department_id')->after('category_id')->nullable();

            // เพิ่ม foreign key constraints
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');

            // ย้ายข้อมูลจากคอลัมน์เก่าไปคอลัมน์ใหม่ (ถ้าจำเป็น)
            // คุณอาจต้องทำขั้นตอนนี้ด้วย PHP หรือ SQL query หลังจาก migration
        });
    }

    public function down()
    {
        Schema::table('travelodges', function (Blueprint $table) {
            // ลบ foreign key constraints
            $table->dropForeign(['category_id']);
            $table->dropForeign(['department_id']);

            // ลบคอลัมน์
            $table->dropColumn('category_id');
            $table->dropColumn('department_id');
        });
    }
};
