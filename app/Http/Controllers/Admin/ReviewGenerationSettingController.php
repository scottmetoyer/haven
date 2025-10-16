<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReviewGenerationSetting;
use Illuminate\Http\Request;

class ReviewGenerationSettingController extends Controller
{
    /**
     * Display the settings form.
     */
    public function index()
    {
        $settings = ReviewGenerationSetting::all()->pluck('setting_value', 'setting_key');
        return view('admin.review-settings.index', compact('settings'));
    }

    /**
     * Update the settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'runpod_api_endpoint' => 'nullable|url',
            'runpod_api_key' => 'nullable|string',
            'runpod_timeout' => 'nullable|integer|min:1',
            'default_review_prompt_template' => 'nullable|string',
            'auto_publish_enabled' => 'boolean',
            'rate_limit_per_hour' => 'nullable|integer|min:1',
        ]);

        foreach ($validated as $key => $value) {
            if ($key === 'auto_publish_enabled') {
                $value = $request->has('auto_publish_enabled');
            }

            ReviewGenerationSetting::updateOrCreate(
                ['setting_key' => $key],
                ['setting_value' => $value]
            );
        }

        return redirect()->route('admin.review-settings.index')
            ->with('success', 'Settings updated successfully.');
    }
}
