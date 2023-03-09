<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('address', 100)->unique()->comment('地址');
            $table->string('nickname')->default('')->comment('昵称');
            $table->integer('avatar_nft_no')->default(-1)->comment('头像nft 编号:-1.没有，0.免费，其他.正常nft');
            $table->string('avatar')->default('')->comment('头像url');
            $table->integer('created_at')->default(0)->unsigned();
            $table->integer('updated_at')->default(0)->unsigned();
        });
        table_comment('members', '用户');
    }

    public function down()
    {
        Schema::dropIfExists('members');
    }
};
