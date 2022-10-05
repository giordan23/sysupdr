<?php

namespace Database\Seeders;

use App\Models\Adviser;
use App\Models\Author;
use App\Models\Certificate;
use App\Models\Denominacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([UsersTableSeeder::class]);


        $author1 = Author::create([
            'dni' => '72235379',
            'full_name' => 'POCCOMO HUAMAN, Jovanny Edwin',
            'n_boucher' => '2323',
            'amount_paid' => '1048',
            'program' => 'TITULO',
            'created_at' => Carbon::now()
        ]);

        $author2 = Author::create([
            'dni' => '12312312',
            'full_name' => 'HUAMAN MELGAR, Judith Raynalda',
            'n_boucher' => '23123',
            'amount_paid' => '2323',
            'program' => 'TITULO',
            'created_at' => Carbon::now()
        ]);

        $adviser1 = Adviser::create([
            'full_name' => 'Mtro. ORE ROJAS, Juan José',
            'dni' => '19873202',
            'email' => 'asdasd@asd',
            'faculty'    => 'asdasdasd',
            'orcid' => 'asdasdasd',
            'created_at' => Carbon::now()
        ]);


        $d1 = Denominacion::create(['nombre' => 'CIENCIAS DE LA EDUCACION']);
        $d2 = Denominacion::create(['nombre' => 'CIENCIAS DE LA SALUD']);
        $d3 = Denominacion::create(['nombre' => 'INGENIERIA']);
        $d4 = Denominacion::create(['nombre' => 'DERECHO Y CIENCIAS POLITICAS']);

        Certificate::create([
            'title' => 'IDENTIDAD CULTURAL EN LOS NIÑOS QUECHUA HABLANTES DEL 6° GRADO DE LA INSTITUCIÓN EDUCATIVA N°31278 DE PUCARUMI - TAYACAJA',
            'program' => 'BACHILLER',
            'document_number' => 'Nº 0001-2022',
            'originality' => 100,
            'similitude' => 0,
            'denominacion_id' => $d1->id,
            'date' => Carbon::now()->format('d-m-Y'),
            'resolucion_ruta' => 'ruta/prueba',
            'observation' => 'asdasd',
            'author_id' => $author1->id,
            'author2_id' => $author2->id,
            'adviser_id' => $adviser1->id,
            'created_at' => Carbon::now()
        ]);
    }
}
