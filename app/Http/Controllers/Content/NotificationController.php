<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\NotificationRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\Notification;
use Flash;

class NotificationController extends AppBaseController
{
    /** @var NotificationRepository $notificationRepository*/
    private $notificationRepository;

    public function __construct(NotificationRepository $notificationRepo)
    {
        parent::__construct();

        $this->notificationRepository = $notificationRepo;
    }

    /**
     * Display a listing of the Notification.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $notifications = $this->notificationRepository->paginate($perPage);

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            Notification::class
        ]);

        $this->template = 'pages.notifications.index';

        return $this->renderOutput([
            'notifications' => $notifications,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new Notification.
     */
    public function create()
    {
        $this->template = 'pages.notifications.create';

        return $this->renderOutput();
    }

    /**
     * Store a newly created Notification in storage.
     */
    public function store(CreateNotificationRequest $request)
    {
        $input = $request->all();

        $notification = $this->notificationRepository->create($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('notifications.index'));
    }

    /**
     * Display the specified Notification.
     */
    public function show($id)
    {
        $notification = $this->notificationRepository->find($id);

        if (empty($notification)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('notifications.index'));
        }

        $this->template = 'pages.notifications.show';

        return $this->renderOutput(compact('notification'));
}

    /**
     * Show the form for editing the specified Notification.
     */
    public function edit($id)
    {
        $notification = $this->notificationRepository->find($id);

        if (empty($notification)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('notifications.index'));
        }

        $this->template = 'pages.notifications.edit';

        return $this->renderOutput(compact('notification'));
    }

    /**
     * Update the specified Notification in storage.
     */
    public function update($id, UpdateNotificationRequest $request)
    {
        $notification = $this->notificationRepository->find($id);

        if (empty($notification)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('notifications.index'));
        }

        $notification = $this->notificationRepository->update($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        return redirect(route('notifications.index'));
    }

    /**
     * Remove the specified Notification from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $notification = $this->notificationRepository->find($id);

        if (empty($notification)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('notifications.index'));
        }

        $this->notificationRepository->delete($id);

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('notifications.index'));
    }
}
