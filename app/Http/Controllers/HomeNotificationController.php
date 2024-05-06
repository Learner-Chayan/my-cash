<?php

namespace App\Http\Controllers;

use App\Http\Requests\HomeNotificationRequest;
use App\Services\HomeNotificationService;
use Exception;
use Illuminate\Support\Facades\DB;

class HomeNotificationController extends Controller
{
    protected $homeNotificationService;
    protected $user;
    public function __construct(HomeNotificationService $homeNotificationService)
    {
        $this->middleware(['auth','Setting','role:admin|super-admin']);
        $this->homeNotificationService = $homeNotificationService;
        $this->middleware(function ($request,$next){
            $this->user = auth()->user();
            return $next($request);
        });
    }

    public function index()
    {
        $data['page_title'] = "Home notification list";
        $data['notifications']     = $this->homeNotificationService->list();
        return view('admin.home-notification.index',$data);

    }
    public function create()
    {
        $data['page_title'] = "Add new home notification";
        return view('admin.home-notification.create',$data);

    }
    public function store(HomeNotificationRequest $request)
    {
        try {
            DB::beginTransaction();
            $in = $request->all();
            $notification = $this->homeNotificationService->store($in);
            if ($request->hasFile('image')) {
                $notification->addMedia($request->file('image'))->toMediaCollection('home_notification');
            }
            DB::commit();
            return redirect()->route('home-notification.index')->with('success', 'Home Notification successfully created');

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }
    public function edit($id)
    {
        $data['page_title']   = "Home notification edit";
        $data['notification'] = $this->homeNotificationService->notificationGet($id);
        $data['image']        = $this->homeNotificationService->getImage($id);
        return view('admin.home-notification.edit',$data);
    }
    public function update(HomeNotificationRequest $request,$id)
    {
        try {
            DB::beginTransaction();
            $in = $request->all();
            $notification = $this->homeNotificationService->update($in,$id);

            if ($request->hasFile('image')) {
                $notification->clearMediaCollection('home_notification');
                $notification->addMedia($request->file('image'))->toMediaCollection('home_notification');
            }
            DB::commit();
            return redirect()->route('home-notification.index')->with('success', 'Home Notification successfully update');

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }
    public function destroy($id)
    {
        $this->homeNotificationService->delete($id);
        return redirect()->route('home-notification.index')->with('success', 'Home Notification successfully delete');

    }
}
