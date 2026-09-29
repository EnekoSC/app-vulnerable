<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // admin con credenciales por defecto (admin/admin)
        $admin = User::create([
            'name' => 'Administración Santa',
            'email' => 'admin@santasl.local',
            'password' => Hash::make('admin'),
            'role' => 'admin',
            'is_admin' => true,
        ]);

        // clientes con contraseñas flojas
        $clientes = [
            ['name' => 'Noel Fría',    'email' => 'noel@santasl.local'],
            ['name' => 'Mari Estrella', 'email' => 'mari@santasl.local'],
            ['name' => 'Elf Ayudante',  'email' => 'elf@santasl.local'],
        ];

        $creados = [];
        foreach ($clientes as $c) {
            $creados[] = User::create([
                'name' => $c['name'],
                'email' => $c['email'],
                'password' => Hash::make('123456'),
                'role' => 'cliente',
                'is_admin' => false,
            ]);
        }

        // catalogo de juguetes
        $productos = [
            ['nombre' => 'Tren de madera Polo Norte',   'descripcion' => 'Set de 40 piezas de madera de haya.',        'precio' => 34.90, 'stock' => 120],
            ['nombre' => 'Peluche Reno Rodolfo',        'descripcion' => 'Peluche de 30 cm, apto para +0 años.',       'precio' => 19.95, 'stock' => 300],
            ['nombre' => 'Puzzle Aldea Nevada 1000pz',  'descripcion' => 'Puzzle de 1000 piezas, 68x48 cm.',           'precio' => 12.50, 'stock' => 80],
            ['nombre' => 'Set de pinturas Duende',      'descripcion' => '24 rotuladores lavables no tóxicos.',        'precio' => 9.99,  'stock' => 500],
            ['nombre' => 'Cocinita de juguete Nórdica', 'descripcion' => 'Cocina de madera con accesorios.',           'precio' => 79.00, 'stock' => 25],
            ['nombre' => 'Coche teledirigido Trineo',   'descripcion' => 'RC 1:18, alcance 30 m, batería incluida.',   'precio' => 45.00, 'stock' => 60],
            ['nombre' => 'Muñeca Estrella Polar',       'descripcion' => 'Muñeca articulada de 45 cm.',                'precio' => 24.90, 'stock' => 140],
            ['nombre' => 'Bloques de construcción 200', 'descripcion' => 'Caja de 200 bloques compatibles.',           'precio' => 29.90, 'stock' => 210],
            ['nombre' => 'Patinete infantil Copo',      'descripcion' => 'Patinete 3 ruedas, hasta 20 kg.',            'precio' => 39.90, 'stock' => 45],
            ['nombre' => 'Kit ciencia Pequeño Elfo',    'descripcion' => 'Experimentos seguros para +8 años.',         'precio' => 22.50, 'stock' => 70],
        ];

        $prodModels = [];
        foreach ($productos as $p) {
            $prodModels[] = Product::create($p);
        }

        // facturas correlativas, varias por cliente
        $numero = 1;
        foreach ($creados as $cliente) {
            $n = rand(2, 4);
            for ($i = 0; $i < $n; $i++) {
                Invoice::create([
                    'user_id' => $cliente->id,
                    'numero' => 'F-2024-'.str_pad((string) $numero, 4, '0', STR_PAD_LEFT),
                    'concepto' => 'Pedido mayorista de temporada',
                    'importe' => rand(15000, 480000) / 100,
                    'pdf_path' => 'factura_'.$numero.'.pdf',
                    'created_at' => now()->subDays(rand(1, 90)),
                ]);
                $numero++;
            }
        }

        // alguna factura del propio admin para que haya de todo
        Invoice::create([
            'user_id' => $admin->id,
            'numero' => 'F-2024-'.str_pad((string) $numero, 4, '0', STR_PAD_LEFT),
            'concepto' => 'Material interno de oficina',
            'importe' => 320.50,
            'pdf_path' => 'factura_'.$numero.'.pdf',
            'created_at' => now()->subDays(10),
        ]);

        // comentarios normales para dar cuerpo al catalogo
        $texto = [
            'Muy buena calidad, repetiremos pedido.',
            'Llegó a tiempo para la campaña de Navidad.',
            'A mis clientes les encanta este producto.',
            'El embalaje se puede mejorar, por lo demás perfecto.',
            'Relación calidad-precio estupenda.',
        ];

        foreach ($prodModels as $prod) {
            $cuantos = rand(1, 3);
            for ($i = 0; $i < $cuantos; $i++) {
                $autor = $creados[array_rand($creados)];
                Comment::create([
                    'product_id' => $prod->id,
                    'user_id' => $autor->id,
                    'autor' => $autor->name,
                    'cuerpo' => $texto[array_rand($texto)],
                    'created_at' => now()->subDays(rand(1, 60)),
                ]);
            }
        }
    }
}
