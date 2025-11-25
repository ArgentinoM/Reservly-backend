<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Retrato Fotográfico',
                'desc' => 'Sesión profesional de retratos en estudio o locación, ideal para portafolios personales o corporativos.',
                'img' => 'https://res.cloudinary.com/dmow8n7pu/image/upload/w_1200,c_limit,f_auto,q_auto/v1761337866/retrato_fotografico_xjbetl.jpg',
                'category_id' => 1,
            ],
            [
                'name' => 'Sonido Profesional para Eventos',
                'desc' => 'Servicio de sonido con equipos de alta fidelidad para eventos sociales y empresariales.',
                'img' => 'https://res.cloudinary.com/dmow8n7pu/image/upload/w_1200,c_limit,f_auto,q_auto/v1761333633/sonido_m6ym3l.jpg',
                'category_id' => 8,
            ],
            [
                'name' => 'Decorador de Fiestas',
                'desc' => 'Decoración temática con flores, luces y mobiliario para todo tipo de celebraciones.',
                'img' => 'https://res.cloudinary.com/dmow8n7pu/image/upload/w_1200,c_limit,f_auto,q_auto/v1761334420/decorador_fiestas_a8bkeo.jpg',
                'category_id' => 9,
            ],
            [
                'name' => 'Fotografía Gastronómica',
                'desc' => 'Fotografía profesional para menús, redes sociales y promoción de restaurantes.',
                'img' => 'https://res.cloudinary.com/dmow8n7pu/image/upload/w_1200,c_limit,f_auto,q_auto/v1761335290/fotografo_gastronimico_qa8qbx.jpg',
                'category_id' => 1,
            ],
            [
                'name' => 'Música y DJ para Eventos',
                'desc' => 'DJ profesional con mezclas personalizadas y equipo completo para ambientar tus fiestas.',
                'img' => 'https://res.cloudinary.com/dmow8n7pu/image/upload/w_1200,c_limit,f_auto,q_auto/v1761333635/musica_y_dj_g4ubpi.jpg',
                'category_id' => 8,
            ],
            [
                'name' => 'Grabación de Comerciales',
                'desc' => 'Producción y grabación de spots publicitarios para TV, radio y redes sociales.',
                'img' => 'https://res.cloudinary.com/dmow8n7pu/image/upload/w_1200,c_limit,f_auto,q_auto/v1761335295/grabacion_comerciales_vfgyg6.jpg',
                'category_id' => 17,
            ],
            [
                'name' => 'Mantenimiento Web',
                'desc' => 'Soporte y mantenimiento técnico de sitios web, actualizaciones y optimización SEO.',
                'img' => 'https://res.cloudinary.com/dmow8n7pu/image/upload/w_1200,c_limit,f_auto,q_auto/v1761335515/mantenimiento_web_cqsmsk.jpg',
                'category_id' => 5,
            ],
            [
                'name' => 'Fotografía de Bodas',
                'desc' => 'Cobertura completa de bodas con edición profesional y álbum digital incluido.',
                'img' => 'https://res.cloudinary.com/dmow8n7pu/image/upload/w_1200,c_limit,f_auto,q_auto/v1761334643/fotografo_bodas_cnmzw9.jpg',
                'category_id' => 1,
            ],
            [
                'name' => 'Diseño de Moda',
                'desc' => 'Diseños exclusivos y confección personalizada para pasarelas o eventos especiales.',
                'img' => 'https://res.cloudinary.com/dmow8n7pu/image/upload/w_1200,c_limit,f_auto,q_auto/v1761334022/diseno_moda_mnidsb.jpg',
                'category_id' => 3,
            ],
            [
                'name' => 'Fotografía de Interiores',
                'desc' => 'Fotografía arquitectónica y de interiores para catálogos y proyectos inmobiliarios.',
                'img' => 'https://res.cloudinary.com/dmow8n7pu/image/upload/w_1200,c_limit,f_auto,q_auto/v1761335291/fotografo_interiores_cdjhav.jpg',
                'category_id' => 1,
            ],
            [
                'name' => 'Producción Teatral',
                'desc' => 'Coordinación, montaje y producción de obras teatrales profesionales.',
                'img' => 'https://res.cloudinary.com/dmow8n7pu/image/upload/w_1200,c_limit,f_auto,q_auto/v1761334422/produccion_teatral_ukmyjq.jpg',
                'category_id' => 17,
            ],
            [
                'name' => 'Coaching Personal',
                'desc' => 'Sesiones personalizadas para desarrollo profesional y crecimiento personal.',
                'img' => 'https://res.cloudinary.com/dmow8n7pu/image/upload/w_1200,c_limit,f_auto,q_auto/v1761334021/couching_gskw6h.jpg',
                'category_id' => 10,
            ],
            [
                'name' => 'Renta de Luces LED',
                'desc' => 'Alquiler de luces profesionales para eventos, escenarios o filmaciones.',
                'img' => 'https://res.cloudinary.com/dmow8n7pu/image/upload/w_1200,c_limit,f_auto,q_auto/v1761335917/renta_luces_led_itpdxb.jpg',
                'category_id' => 12,
            ],
            [
                'name' => 'Desarrollo Web Profesional',
                'desc' => 'Creación de sitios web modernos, responsivos y optimizados para SEO.',
                'img' => 'https://res.cloudinary.com/dmow8n7pu/image/upload/w_1200,c_limit,f_auto,q_auto/v1761334020/desarrollo_web_lcdrcf.jpg',
                'category_id' => 5,
            ],
            [
                'name' => 'Video Promocional con Dron',
                'desc' => 'Grabaciones aéreas con dron para videos promocionales o inmobiliarios.',
                'img' => 'https://res.cloudinary.com/dmow8n7pu/image/upload/w_1200,c_limit,f_auto,q_auto/v1761335916/dron_video_rpomocial_gounk9.jpg',
                'category_id' => 2,
            ],
            [
                'name' => 'Desarrollo de Aplicaciones',
                'desc' => 'Diseño y desarrollo de apps móviles para Android e iOS.',
                'img' => 'https://res.cloudinary.com/dmow8n7pu/image/upload/w_1200,c_limit,f_auto,q_auto/v1761334191/desarrollo_app_auvypr.jpg',
                'category_id' => 6,
            ],
            [
                'name' => 'Producción Audiovisual',
                'desc' => 'Producción completa de contenido audiovisual para empresas y artistas.',
                'img' => 'https://res.cloudinary.com/dmow8n7pu/image/upload/w_1200,c_limit,f_auto,q_auto/v1761334193/audiovisual_tpfmsd.jpg',
                'category_id' => 17,
            ],
            [
                'name' => 'Organización de Conferencias',
                'desc' => 'Planificación y gestión integral de conferencias y seminarios.',
                'img' => 'https://res.cloudinary.com/dmow8n7pu/image/upload/w_1200,c_limit,f_auto,q_auto/v1761335515/organizacion_conferencias_ylrb9a.jpg',
                'category_id' => 7,
            ],
            [
                'name' => 'Eventos Corporativos',
                'desc' => 'Organización de eventos empresariales con catering y ambientación profesional.',
                'img' => 'https://res.cloudinary.com/dmow8n7pu/image/upload/w_1200,c_limit,f_auto,q_auto/v1761334194/eventos_tmbkr2.jpg',
                'category_id' => 7,
            ],
            [
                'name' => 'Consultoría Empresarial',
                'desc' => 'Asesoría estratégica en desarrollo de negocios, marketing y ventas.',
                'img' => 'https://res.cloudinary.com/dmow8n7pu/image/upload/w_1200,c_limit,f_auto,q_auto/v1761334834/consultorios_uraoid.jpg',
                'category_id' => 10,
            ],
            [
                'name' => 'Editor Fotográfico',
                'desc' => 'Edición profesional de fotografías, retoque y corrección de color.',
                'img' => 'https://res.cloudinary.com/dmow8n7pu/image/upload/w_1200,c_limit,f_auto,q_auto/v1761334418/editor_fotografico_gxxwal.jpg',
                'category_id' => 1,
            ],
            [
                'name' => 'Diseño de Tarjetas de Presentación',
                'desc' => 'Diseño personalizado de tarjetas corporativas en alta resolución.',
                'img' => 'https://res.cloudinary.com/dmow8n7pu/image/upload/w_1200,c_limit,f_auto,q_auto/v1761335514/dise%C3%B1o_tarjetas_presentacion_ov4tzo.jpg',
                'category_id' => 3,
            ],
            [
                'name' => 'Diseño Gráfico Profesional',
                'desc' => 'Servicios de branding, identidad visual y diseño gráfico digital.',
                'img' => 'https://res.cloudinary.com/dmow8n7pu/image/upload/w_1200,c_limit,f_auto,q_auto/v1761334645/diseno_grafico_d35gd8.jpg',
                'category_id' => 3,
            ],
            [
                'name' => 'Rediseño de Marcas',
                'desc' => 'Actualización completa de logotipos, colores y branding empresarial.',
                'img' => 'https://res.cloudinary.com/dmow8n7pu/image/upload/w_1200,c_limit,f_auto,q_auto/v1761335516/rediseno_marcas_rroboz.jpg',
                'category_id' => 3,
            ],
            [
                'name' => 'Creación de Artículos para Blogs',
                'desc' => 'Redacción optimizada para SEO, blogs corporativos y páginas web.',
                'img' => 'https://res.cloudinary.com/dmow8n7pu/image/upload/w_1200,c_limit,f_auto,q_auto/v1761335925/creacion_articulos_ch0hww.jpg',
                'category_id' => 11,
            ],
            [
                'name' => 'Iluminación para Fiestas',
                'desc' => 'Instalación de sistemas de iluminación profesional para eventos.',
                'img' => 'https://res.cloudinary.com/dmow8n7pu/image/upload/w_1200,c_limit,f_auto,q_auto/v1761334645/iluminacion_fiestas_dosiyf.jpg',
                'category_id' => 12,
            ],
            [
                'name' => 'Redacción Profesional',
                'desc' => 'Escritura y corrección de textos académicos, publicitarios y técnicos.',
                'img' => 'https://res.cloudinary.com/dmow8n7pu/image/upload/w_1200,c_limit,f_auto,q_auto/v1761334643/redaccion_syenkg.jpg',
                'category_id' => 11,
            ],
            [
                'name' => 'Gestión de Redes Sociales',
                'desc' => 'Administración de perfiles, contenido y estrategias de redes sociales.',
                'img' => 'https://res.cloudinary.com/dmow8n7pu/image/upload/w_1200,c_limit,f_auto,q_auto/v1761335524/editor_redes_sociales_ye9tki.jpg',
                'category_id' => 4,
            ],
            [
                'name' => 'Creación de Contenido TikTok',
                'desc' => 'Desarrollo de videos virales y estrategias para TikTok y Reels.',
                'img' => 'https://res.cloudinary.com/dmow8n7pu/image/upload/f_auto,q_auto,w_1200,c_limit/v1761335518/creacion_tioktok_oziw1h.jpg',
                'category_id' => 4,
            ],
            [
                'name' => 'Traducción de Libros',
                'desc' => 'Servicio profesional de traducción literaria y técnica en varios idiomas.',
                'img' => 'https://res.cloudinary.com/dmow8n7pu/image/upload/w_1200,c_limit,f_auto,q_auto/v1761335918/traduccion_libros_uaubsm.jpg',
                'category_id' => 11,
            ],
        ];

        foreach ($services as &$service) {
            $service['user_id'] = rand(2, 4);
            $service['price'] = rand(500, 10000);
            $service['duration'] = rand(1, 24);
        }

        DB::table('services')->insert($services);
    }
}
