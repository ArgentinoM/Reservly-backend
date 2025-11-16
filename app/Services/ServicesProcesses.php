<?php

namespace App\Services;

use App\Data\ServiceData;
use App\Exceptions\ApiException;
use App\Models\Services;
use App\Models\User;
use Cloudinary\Api\Upload\UploadApi;
use Illuminate\Support\Facades\Storage;

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

        if (!$service) {
            throw new ApiException(
                'No se encuentra el servicio'
            );
        }

        if ($data->img->hasFile('img')) {
            if ($service->img) {
                Storage::disk('cloudinary')->delete($service->img);
            }

            $service->img = $data->img->file('img');
        }


        $service->update([
            'name' => $data->name,
            'desc' => $data->desc,
            'desc' => $data->price,
            'desc' => $data->duration,
            'desc' => $data->img,
            'desc' => $data->category_id,
        ]);

        return $service;
    }
}
