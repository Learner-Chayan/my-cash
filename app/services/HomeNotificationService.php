<?php
namespace App\Services;


use App\Models\HomeNotification;

class HomeNotificationService

{

    public function list()
    {
        return HomeNotification::latest()->get();
    }

    public function notificationGet($id)
    {
        return HomeNotification::findOrFail($id);
    }
    public function store(array $data)
    {
        return HomeNotification::create($data);
    }
    public function update(array $data,$id)
    {
        $notification = $this->notificationGet($id);
        $notification->update($data);
        return $notification;
    }
    public function delete($id)
    {
        $notification = $this->notificationGet($id);
        $notification->clearMediaCollection('home_notification');
        $notification->delete();
        return 0;
    }
    public function getImage($id)
    {
        $notification = $this->notificationGet($id);

        $media    = $notification->getMedia('home_notification')->first();
        $imageUrl = $media ? $media->getUrl() : '';

        return $imageUrl;
    }

}
