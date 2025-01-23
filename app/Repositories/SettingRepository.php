<?php
// app/Repositories/SettingRepository.php
namespace App\Repositories;

use App\Models\Setting;

class SettingRepository implements RepositoryInterface
{
    public function create(array $data)
    {
        return Setting::create($data);
    }

    public function update(array $data, $id)
    {
        $setting = Setting::findOrFail($id);
        $setting->update($data);
        return $setting;
    }

    public function delete($id)
    {
        return Setting::destroy($id);
    }

    public function findById($id)
    {
        return Setting::findOrFail($id);
    }

    public function findFirst()
    {
        return Setting::first();
    }

    public function getAll()
    {
        return Setting::all();
    }

    public function paginate($perPage = 15)
    {
        return Setting::paginate($perPage);
    }
}
