<?php

namespace App\Http\Controllers\PublicUser;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementControllerPublic extends Controller
{
    function index()
    {
        $announcements = Announcement::orderBy('id', 'desc')->paginate(8)->withQueryString();
 
        $data = [
            'title' => 'Pengumuman Resmi Desa Pemali',
            'announcements' => $announcements,
        ];

        return view('public-user.announcement.index', $data);
    }

    function detail($slug)
    {
        $detailAnnouncements = Announcement::where('slug', $slug)->firstOrFail();
        $latestAnnouncements = Announcement::latest()->limit(2)->get();
        $popularAnnouncement = Announcement::orderBy('seen', 'desc')->limit(2)->get();

        $detailAnnouncements->seen = $detailAnnouncements->seen + 1;
        $detailAnnouncements->save();
 
        $data = [
            'title' => 'Detail Pengumuman',
            'dA' => $detailAnnouncements,
            'latestAnnouncements' => $latestAnnouncements,
            'popularAnnouncement' => $popularAnnouncement,
        ];

        return view('public-user.announcement.detail', $data);
    }
}
