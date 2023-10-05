
<?php

use Illuminate\Support\Facades\Cache;

$config = App\Models\Config::first();

    $kotas = App\Models\Regency::join('regency_domains','regency_domains.regency_id','=','regencies.id')
        ->where('regencies.province_id', $config->provinces_id)->get();
    $client = new GuzzleHttp\Client(); //GuzzleHttp\Client

?>
<div class="card">
    <div class="card-header">
        <div class="card-title">Tabulasi (Provinsi Banten)</div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg justify-content-end">
                <div class="card">
                    <div class="card-header bg-secondary">
                        <div class="card-title text-white">Total TPS</div>
                    </div>
                    <div class="card-body">
                        <h3 class="">
                            <?php $tps_total = 0; ?>
                            @foreach ($kotas as $hehe)
                                <?php
                                 
                                    $url = "https://".$hehe->domain."/api/public/get-tps";
                                    $voices = Cache::get($url, function () use ($client, $url) {
                                            $response = $client->request('GET', $url, ['headers' => [
                                            'Authorization' => 'Bearer '.'123789',
                                            'Accept' => 'application/json',
                                        ],]);
                                            $voices = json_decode($response->getBody());
                                            Cache::put($url, $voices, 60);
                                            return $voices;
                                        });
                                 
                                    
                                ?>

                               @foreach($voices as $vcs)
                                <?php $tps_total += $vcs; ?>
                                @endforeach

                          @endforeach
                            {{$tps_total}}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-lg">
                <div class="card">
                    <div class="card-header bg-danger">
                        <div class="card-title text-white">TPS Masuk</div>
                    </div>
                    <div class="card-body">
                        <h3 class="">
                            <?php $tps_masuk = 0; ?>
                            @foreach ($kotas as $hehe)

                                <?php
                                 
                                    $url = "https://".$hehe->domain."/api/public/get-tps-masuk";
                                      $voices = Cache::get($url, function () use ($client, $url) {
                                            $response = $client->request('GET', $url, ['headers' => [
                                            'Authorization' => 'Bearer '.'123789',
                                            'Accept' => 'application/json',
                                        ],]);
                                            $voices = json_decode($response->getBody());
                                            Cache::put($url, $voices, 60);
                                            return $voices;
                                        });
                           
                                    
                                ?>

                               @foreach($voices as $vcs)
                                <?php $tps_masuk += $vcs; ?>
                                @endforeach

                            @endforeach
                            {{$tps_masuk}}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-lg">
                <div class="card">
                    <div class="card-header bg-primary">
                        <div class="card-title text-white">TPS Kosong</div>
                    </div>
                    <div class="card-body">
                        <h3 class="">
                            <?php $tps_kosong = 0; ?>
                            @foreach ($kotas as $hehe)

                                <?php
                              
                                    $url = "https://".$hehe->domain."/api/public/get-tps-kosong";
                                     $voices = Cache::get($url, function () use ($client, $url) {
                                            $response = $client->request('GET', $url, ['headers' => [
                                            'Authorization' => 'Bearer '.'123789',
                                            'Accept' => 'application/json',
                                        ],]);
                                            $voices = json_decode($response->getBody());
                                            Cache::put($url, $voices, 60);
                                            return $voices;
                                        });
                                 
                                    
                                ?>

                               @foreach($voices as $vcs)
                                <?php $tps_kosong += $vcs; ?>
                                @endforeach

                          @endforeach
                            {{$tps_kosong}}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-lg">
                <div class="card">
                    <div class="card-header bg-cyan">
                        <div class="card-title text-white">Suara Masuk</div>
                    </div>
                    <div class="card-body">
                        <h3 class="">
                            <?php $suara_masuk = 0; ?>
                            @foreach ($kotas as $hehe)
                                <?php

                                    $url = "https://".$hehe->domain."/api/public/get-voice?jenis=suara_masuk";
                                     $voices = Cache::get($url, function () use ($client, $url) {
                                            $response = $client->request('GET', $url, [
                                                'headers' => [
                                            'Authorization' => 'Bearer '.'123789',
                                            'Accept' => 'application/json',
                                        ],
                                            ]);
                                            $voices = json_decode($response->getBody());
                                            Cache::put($url, $voices, 60);
                                            return $voices;
                                        });
                                 
                                ?>

                               @foreach($voices as $vcs)
                                <?php $suara_masuk += $vcs->voice; ?>
                                @endforeach

                          @endforeach
                            {{$suara_masuk}}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-lg">
                <div class="card">
                    <div class="card-header bg-success">
                        <div class="card-title text-white">Suara Terverifikasi</div>
                    </div>
                    <div class="card-body">
                        <h3 class="">
                        <?php $suara_terverifikasi = 0; ?>
                            @foreach ($kotas as $hehe)

                                <?php
                                
                                    $url = "https://".$hehe->domain."/api/public/get-voice?jenis=suara_terverifikasi";
                                    
                                  $voices = Cache::get($url, function () use ($client, $url) {
                                            $response = $client->request('GET', $url, [
                                                'headers' => [
                                            'Authorization' => 'Bearer '.'123789',
                                            'Accept' => 'application/json',
                                        ],
                                            ]);
                                            $voices = json_decode($response->getBody());
                                            Cache::put($url, $voices, 60);
                                            return $voices;
                                        });
                                 
                                ?>

                               @foreach($voices as $vcs)
                                <?php $suara_terverifikasi += $vcs->voice; ?>
                                @endforeach

                          @endforeach
                            {{$suara_terverifikasi}}

                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
