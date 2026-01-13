<?php

namespace App\Http\Controllers;

use App\Models\Raid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RaidController extends Controller
{
    public function getRaids()
    {
        return null;
    }

    public function createRaids(
        Request $request,
        $name,
        $mail = null,
        $phone = null,
        $site = null,
        $image = null,
        $time_start,
        $time_end,
        $registration_start,
        $registration_end
    )
    {
        $validator = Validator::make($request->all(), [
            'name'               => 'required|string|max:255',
            // mail OR phone required (at least one)
            'mail'               => 'nullable|email|max:255|required_without:phone',
            'phone'              => 'nullable|string|max:20|required_without:mail',
            'site'               => 'nullable|url|max:255',
            'image'              => 'nullable|image|max:2048',
            'time_start'         => 'required|date_format:Y-m-d H:i:s',
            'time_end'           => 'required|date_format:Y-m-d H:i:s|after:time_start',
            'registration_start' => 'required|date_format:Y-m-d H:i:s|before:time_start',
            'registration_end'   => 'required|date_format:Y-m-d H:i:s|before:time_start|after:registration_start',
        ]);

        if ($validator->fails()) {
            // return back()->withErrors($validator)->withInput();
        }

        $raid = Raid::create([
            'RAI_NAME'               => $name,
            'RAI_MAIL'               => $mail,
            'RAI_PHONE_NUMBER'       => $phone,
            'RAI_WEB_SITE'           => $site,
            'RAI_IMAGE'              => $image,
            'RAI_TIME_START'         => $time_start,
            'RAI_TIME_END'           => $time_end,
            'RAI_REGISTRATION_START' => $registration_start,
            'RAI_REGISTRATION_END'   => $registration_end,
        ]);

        // return back()->with('success', 'Menu mis à jour avec succès.');
    }
}