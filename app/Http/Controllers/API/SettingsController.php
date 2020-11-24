<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Space\DateFormatter;
use App\Space\TimeZones;
use App\BranchSetting;
use App\Currency;
use App\Branch;
use App\User;

class SettingsController extends Controller
{
        /**
     * Retrieve General App Settings
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGeneralSettings(Request $request)
    {
        $date_formats = DateFormatter::get_list();

        $time_zones = TimeZones::get_list();
        $fiscal_years = [
            ['key' => 'January-December' , 'value' => '1-12'],
            ['key' => 'February-January' , 'value' => '2-1'],
            ['key' => 'March-February'   , 'value' => '3-2'],
            ['key' => 'April-March'      , 'value' => '4-3'],
            ['key' => 'May-April'        , 'value' => '5-4'],
            ['key' => 'June-May'         , 'value' => '6-5'],
            ['key' => 'July-June'        , 'value' => '7-6'],
            ['key' => 'August-July'      , 'value' => '8-7'],
            ['key' => 'September-August' , 'value' => '9-8'],
            ['key' => 'October-September', 'value' => '10-9'],
            ['key' => 'November-October' , 'value' => '11-10'],
            ['key' => 'December-November', 'value' => '12-11'],
        ];

        $language = BranchSetting::getSetting('language', $request->header('branch'));
        $carbon_date_format = BranchSetting::getSetting('carbon_date_format', $request->header('branch'));
        $moment_date_format = BranchSetting::getSetting('moment_date_format', $request->header('branch'));
        $time_zone = BranchSetting::getSetting('time_zone', $request->header('branch'));
        $currency = BranchSetting::getSetting('currency', $request->header('branch'));
        $fiscal_year = BranchSetting::getSetting('fiscal_year', $request->header('branch'));

        $languages = [  // alphabetical order
            ["code"=>"en", "name" => "English"],
            ["code"=>"bm", "name" => "Bahasa Melayu"],
        ];

        return response()->json([
            'languages' => $languages,
            'date_formats' => $date_formats,
            'time_zones' => $time_zones,
            'time_zone' => $time_zone,
            'currencies' => Currency::all(),
            'fiscal_years' => $fiscal_years,
            'fiscal_year' => $fiscal_year,
            'selectedLanguage' => $language,
            'selectedCurrency' => $currency,
            'carbon_date_format' => $carbon_date_format,
            'moment_date_format' => $moment_date_format,
            'status' => $status,
        ]);
    }

    /**
     * Get Admin Account alongside the country from the addresses table and
     * The company from companies table
     *
     * @return \Illuminate\Http\JsonResponse
    */
    public function getCompanyDetail(Request $request)
    {
        $branch = Branch::with(['addresses', 'addresses.country'])->find($request->header('branch'));

        return response()->json([
            'user' => $branch
        ]);
    }

    /**
     * Update the User profile.
     * Includes name, email and (or) password
     *
     */
    public function updateProfile(Request $request){

        $verifyemail = User::where('email', $request->email)->first();

        $user = auth()->user();

        if($verifyemail){
            if($verifyemail->id !== $user->id){
                return respomse()->json([
                    'error' => 'Email already in use'
                ]);
            }
        }

        $user->full_name = $request->name;
        $user->email = $request->email;

        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return response()->json([
            'user' => $user,
            'success' => true
        ]);
    }

    /**
     * Upload the Admin Avatar to public storage.
     */
    public function uploadAvatar(Request $request){
        $data = json_decode($request->admin_avatar);

        if($data) {
            $user = auth()->user();

            if($user) {
                $user->clearMediaCollection('admin_avatar');

                $user->addMediaFromBase64($data->data)
                    ->usingFileName($data->name)
                    ->toMediaCollection('admin_avatar');
            }
        }

        return response()->json([
            'user' => $user,
            'success' => true
        ]);
    }
}
