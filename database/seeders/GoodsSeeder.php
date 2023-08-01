<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GoodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('goods')->insert(
            [
                [
                    'name' => 'Гарнитура Logitech PC Headset 960',
                    'description' => 'Накладные / Полуоткрытые / Крепление: Вертикальная дужка / 20 Hz-20 KHz / 44 дБ / Крепл. мик: Подвижное / Интерфейс подключ: Проводной / Дл. кабеля (радиус действ):2.4 м / Рег. громк: Есть / Доп. функции: Шумоподавление микрофона / Черный',
                    'photo' => '/upload/Sh/imageCache/fff/1c6/0692126d649750e43c7f4f818771fecb.jpeg',
                    'uid' => '3213212452'

                ],
                [
                    'name' => 'Коммутатор TP-Link TL-SG1005D',
                    'description' => 'Портов: 5 (10/100/1000 Мбит/сек) / Неуправляемый / Уровень коммут:2 / Внутрен. пропускн. способн:10 Гбит/с / Стандарты: 802.3 (Ethernet) 802.3u (Fast Ethernet) 802.3x (Flow Control) 802.3ab (1000BASE-T) / Блок пит: Внешний / 1 тыс. адр. / Функции: J',
                    'photo' => 'https://texus.by/upload/iblock/80d/80d4c70ceea0498e97a1ba2958c27599.jpeg',
                    'uid' => '1212213123'
                ],
                [
                    'name' => 'Монитор 23.8" LG 24GN650-B',
                    'description' => '23.8" (1920х1080) 16:9 IPS / Отклик: 1 мс / 16.7 млн / Угол обзора верт: 178°/гориз: 178° / Ярк: 300 кд/м2 / Контр: 1 000:1 / HDMI: Есть / DVI: Нет / VGA: Нет / DisplayPort: 1 / USB 3.1: нет / USB 3.1: нет / USB Type C: нет / Черный / Крепл. к стене:',
                    'photo' => '/upload/Sh/imageCache/94f/0ae/c1c8e5faad289c13aaa664a0a7498211.jpeg',
                    'uid' => '12313145155'
                ],
                [
                    'name' => 'Модуль памяти DDR4 2666Mhz - 16Gb(1х16Gb) "Patriot"',
                    'description' => 'DDR4 / 16 Гб (1x16 Гб) 2666МГц / PC4-21300 / CL: 19 / Радиатор: Есть / Низкопрофильная: Нет / Колич. модулей в компл: 1',
                    'photo' => '/upload/Sh/imageCache/c78/c2f/e663f08cc7a87f51c391718fd947a1c5.jpeg',
                    'uid' => '12123412000'
                ],
                [
                    'name' => 'Мобильный телефон "BQ" Nano [BQ-1411] Dual SIM',
                    'description' => '1.4"TFT (128x128) / Поддержка: 2 SIM, SIM: Стандартная / 32Mb / 32Mb / Есть / USB:micro USB / Аудиовых: Есть / 460 мАч / красный / пластик/ 49 г',
                    'photo' => '/upload/Sh/imageCache/68e/c1a/8ed6170afd1fa26b730e5c5ad76edbb1.jpeg',
                    'uid' => '1111344234'
                ]
            ]
        );
    }
}
