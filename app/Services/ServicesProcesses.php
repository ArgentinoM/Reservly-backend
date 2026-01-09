<?php

namespace App\Services;

use App\Data\ServiceData;
use App\Models\Services;
use Cloudinary\Api\Upload\UploadApi;

class ServicesProcesses
{
    public function createService(ServiceData $data): Services
    {
        $nameSlug = preg_replace('/[^A-Za-z0-9\-]/', '-', $data->name);

        $file = $data->img;

        $fileName = 'services-' . $nameSlug . '.' . $file->getClientOriginalExtension();

        $result = (new UploadApi())->upload($file->getRealPath(), [
            'public_id' => pathinfo($fileName, PATHINFO_FILENAME),
            'overwrite' => true,
        ]);

        $originalUrl = $result['secure_url'];

        $optimizedUrl = str_replace(
            '/upload/',
            '/upload/w_1200,c_limit,f_auto,q_auto/',
            $originalUrl
        );

        return Services::create([
            'name' => $data->name,
            'desc' => $data->desc,
            'price' => $data->price,
            'duration' => $data->duration,
            'img' => $optimizedUrl,
            'user_id' => auth()->id(),
            'category_id' => $data->category_id,
        ]);
    }


    public function updateService(ServiceData $data, int $service_id)
    {
        $service = Services::find($service_id);

        if ($data->img) {
            if ($service->img) {
                Cloudinary()->uploadApi()->destroy($service->name);
            }

            $service->img = Cloudinary()->uploadApi()->upload($data->img->getRealPath(), [
                'public_id' => 'services-' . preg_replace('/[^A-Za-z0-9\-]/', '-', $service->name),
                'overwrite' => true,
            ])['secure_url'];
        }

        $service->update(array_filter([
            'name' => $data->name,
            'desc' => $data->desc,
            'price' => $data->price,
            'duration' => $data->duration,
            'category_id' => $data->category_id,
            'img' => $service->img,
        ], fn($v) => $v !== null));

        return $service;
    }
}
