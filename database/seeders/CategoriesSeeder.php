<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('category_services')->insert([
            [
                'name' => 'Fotografía',
                'desc' => 'Servicios de fotografía profesional para eventos, productos y retratos.'
            ],
            [
                'name' => 'Video',
                'desc' => 'Producción de video, grabación de eventos y clips promocionales.'
            ],
            [
                'name' => 'Diseño Gráfico',
                'desc' => 'Diseño de logotipos, flyers, banners y material digital.'
            ],
            [
                'name' => 'Marketing Digital',
                'desc' => 'Estrategias de redes sociales, SEO, SEM y publicidad online.'
            ],
            [
                'name' => 'Desarrollo Web',
                'desc' => 'Creación de sitios web, landing pages y tiendas en línea.'
            ],
            [
                'name' => 'Desarrollo de Apps',
                'desc' => 'Aplicaciones móviles para iOS y Android personalizadas.'
            ],
            [
                'name' => 'Consultoría',
                'desc' => 'Asesoría profesional en negocios, proyectos y estrategias.'
            ],
            [
                'name' => 'Eventos',
                'desc' => 'Organización y coordinación de eventos corporativos y sociales.'
            ],
            [
                'name' => 'Música y DJ',
                'desc' => 'Servicios de música en vivo, DJ para fiestas y eventos.'
            ],
            [
                'name' => 'Catering',
                'desc' => 'Servicio de alimentos y bebidas para todo tipo de eventos.'
            ],
            [
                'name' => 'Decoración',
                'desc' => 'Decoración de espacios y ambientación para eventos.'
            ],
            [
                'name' => 'Animación',
                'desc' => 'Animadores, payasos, magos y entretenimiento para eventos infantiles.'
            ],
            [
                'name' => 'Fotografía Aérea',
                'desc' => 'Drones para fotografía y video aéreo profesional.'
            ],
            [
                'name' => 'Producción Teatral',
                'desc' => 'Montaje de obras y eventos teatrales.'
            ],
            [
                'name' => 'Publicidad',
                'desc' => 'Campañas publicitarias, banners y material impreso.'
            ],
            [
                'name' => 'Traducción',
                'desc' => 'Servicios de traducción profesional para documentos y sitios web.'
            ],
            [
                'name' => 'Redacción',
                'desc' => 'Creación de contenido, blogs y copywriting profesional.'
            ],
            [
                'name' => 'Fotografía de Productos',
                'desc' => 'Fotografía profesional de productos para e-commerce.'
            ],
            [
                'name' => 'Imagen Corporativa',
                'desc' => 'Branding y desarrollo de imagen corporativa completa.'
            ],
            [
                'name' => 'Producción Audiovisual',
                'desc' => 'Proyectos completos de audio y video para marcas.'
            ],
            [
                'name' => 'Streaming',
                'desc' => 'Transmisiones en vivo para eventos, webinars y shows.'
            ],
            [
                'name' => 'Iluminación',
                'desc' => 'Servicios de iluminación profesional para eventos y escenarios.'
            ],
            [
                'name' => 'Sonido',
                'desc' => 'Equipos de sonido y técnicos especializados para eventos.'
            ],
            [
                'name' => 'Fotografía de Bodas',
                'desc' => 'Cobertura completa de bodas y eventos sociales.'
            ],
            [
                'name' => 'Fotografía de Retrato',
                'desc' => 'Sesiones de retrato profesional para individuos y familias.'
            ],
            [
                'name' => 'Diseño de Moda',
                'desc' => 'Creación de ropa, vestuario y asesoría de imagen.'
            ],
            [
                'name' => 'Producción de Contenido',
                'desc' => 'Creación de contenido multimedia para redes sociales.'
            ],
            [
                'name' => 'Consultoría Financiera',
                'desc' => 'Asesoramiento en finanzas personales y empresariales.'
            ],
            [
                'name' => 'Coaching',
                'desc' => 'Entrenamiento y desarrollo personal o profesional.'
            ],
            [
                'name' => 'Fotografía Editorial',
                'desc' => 'Fotografía para revistas, periódicos y publicaciones digitales.'
            ],
        ]);
    }
}
