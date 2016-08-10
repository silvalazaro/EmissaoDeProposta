<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');
            // $table->timestamps();            
            $table->string('nome');
            $table->string('telefone');
            $table->string('email');
        });
        
        
        DB::table('clientes')->insert(
                ['nome' => 'Engenharia Total', 'telefone' => '82988356504',
                    'email' => 'email@engtotal.com']
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
