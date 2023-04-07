<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Indicator;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use GuzzleHttp\Client;

class IndicatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client = new Client(['base_uri'=>'https://postulaciones.solutoria.cl/api/']);
        
        $res = $client->request('POST', 'acceso', [
            'json' => [
                'userName' => 'pablomunizcampos@gmail.com',
                'flagJson' => true
            ],
            'verify' => false
        ]);
        $token = json_decode($res->getBody()->getContents())->token;

        $response = Http::withToken($token)->withOptions(['verify'=>false])->get('https://postulaciones.solutoria.cl/api/indicadores');

        $indicators = collect(json_decode($response->getBody()->getContents()))->where('codigoIndicador', 'UF')->all();

        foreach ($indicators as $ind) {
            Indicator::create([
                'name' => $ind->nombreIndicador,
                'symbol'=> $ind->codigoIndicador,
                'currency'=> $ind->unidadMedidaIndicador,
                'value'=> $ind->valorIndicador,
                'date'=> $ind->fechaIndicador,
                'time'=> $ind->tiempoIndicador,
                'source'=> $ind->origenIndicador,
            ]);
        }
    }
}
