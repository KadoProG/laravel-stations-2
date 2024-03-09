<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ScheduleValidationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('schedule_date_time_after_start_date_validation', function ($attribute, $value, $parameters, $validator) {
            $startDateTime = \Carbon\Carbon::parse($validator->getData()['start_time_date']);
            $endDateTime = \Carbon\Carbon::parse($validator->getData()['end_time_date']);

            // 開始日付を終了日付より後の時間にする
            return !($startDateTime->greaterThan($endDateTime));
        });

        Validator::replacer('schedule_date_time_after_start_date_validation', function ($message, $attribute) {
            return str_replace(':attribute', $attribute, '開始日付は終了日付より前に設定する必要があります。');
        });

        Validator::extend('schedule_date_time_after_start_time_validation', function ($attribute, $value, $parameters, $validator) {
            $startDateTime = \Carbon\Carbon::parse($validator->getData()['start_time_time']);
            $endDateTime = \Carbon\Carbon::parse($validator->getData()['end_time_time']);

            // 開始時間を終了時間より後の時間にする
            return $startDateTime->lessThan($endDateTime);
        });

        Validator::replacer('schedule_date_time_after_start_time_validation', function ($message, $attribute) {
            return str_replace(':attribute', $attribute, '開始時間は終了時間より前に設定する必要があります。');
        });

        Validator::extend('schedule_date_time_diff_minute_validation', function ($attribute, $value, $parameters, $validator) {
            $startDateTime = \Carbon\Carbon::parse($validator->getData()['start_time_time']);
            $endDateTime = \Carbon\Carbon::parse($validator->getData()['end_time_time']);

            // 開始時間と終了時間の差が 5 分未満
            return !($startDateTime->diffInMinutes($endDateTime) <= 5);
        });

        Validator::replacer('schedule_date_time_diff_minute_validation', function ($message, $attribute) {
            return str_replace(':attribute', $attribute, '開始時間と終了時間の差を 5 分未満に設定できません。');
        });
    }
}
