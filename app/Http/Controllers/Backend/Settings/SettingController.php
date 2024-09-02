<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Backend\BackendController;
use App\Http\Requests\Backend\SettingsRequest;
use App\Repository\GeneralSettingRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SettingController extends BackendController
{
    public function __construct(
        private GeneralSettingRepositoryInterface $settingRepository,
    )
    {

    }

    public function __invoke(): View
    {
        $settings = $this->settingRepository->get();

        return $this->render('backend.settings.index', compact('settings'));
    }

    public function update(SettingsRequest $request): RedirectResponse
    {
        if ($this->settingRepository->update($request->validated())) {
            $message = ['type' => 'Success', 'message' => 'Contacts has been updated successfully'];
        }

        return redirect()->back()->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

}
