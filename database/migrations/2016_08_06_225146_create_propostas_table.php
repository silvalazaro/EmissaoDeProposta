<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropostasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    var $status = ['EM ELABORAÇÃO', 'PENDENTE DE APROVAÇÃO', 'APROVADA', 'NÃO APROVADA'];
    var $seguimento = ['Análises Ambientais', 'Serviços Operacionais'];

    public function up() {


        Schema::create('propostas', function (Blueprint $table) {
            $table->increments('id');
            // $table->timestamps();
            $table->integer('id_cliente');
            $table->string('nome');
            $table->string('descricao');
            $table->date('vencimento');
        });

        Schema::create('historico_propostas', function (Blueprint $table) {
            $table->increments('id');
            // $table->timestamps();
            $table->integer('id_propostas');
            $table->enum('status', $this->status);
            $table->date('data');
            $table->integer('usuario_editor');
        });


        Schema::create('servicos_propostas', function (Blueprint $table) {
            $table->increments('id');
            // $table->timestamps();
            $table->integer('id_propostas');
            $table->integer('id_servicos');
            $table->decimal('preco', 5, 2);
        });

        Schema::create('servicos', function (Blueprint $table) {
            $table->increments('id');
            // $table->timestamps();
            $table->string('nome');
            $table->enum('seguimento', $this->seguimento);
            $table->decimal('preco', 5, 2);
        });

        DB::table('servicos')->insert(
                [['nome' => 'Saúde ocupacional', 'seguimento' => 'Serviços Operacionais',
                'preco' => 240], ['nome' => 'Limpeza Ambiental', 'seguimento' => 'Serviços Operacionais',
                        'preco' => 380]
                ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('propostas');
    }

}
