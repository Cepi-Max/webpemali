<?php

use App\Http\Controllers\Admin\DashboardSubmissionLetterController;
use App\Http\Controllers\Admin\JenisSuratController;
use App\Http\Controllers\Admin\JenisSuratSyaratController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ArticleCategoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BannerImgController;
use App\Http\Controllers\BannerImgServiceController;
use App\Http\Controllers\ConstructionController;
use App\Http\Controllers\ConstructionDocumentationController;
use App\Http\Controllers\ConstructionFundSourceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\InfografisController;
use App\Http\Controllers\Kewilayahan2Controller;
use App\Http\Controllers\KewilayahanDesaCantikController;
use App\Http\Controllers\KewilayahanKategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\OfficialController;
use App\Http\Controllers\PopulationController;
use App\Http\Controllers\PpidController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicUser\AnnouncementControllerPublic;
use App\Http\Controllers\PublicUser\ArticleControllerPublic;
use App\Http\Controllers\PublicUser\ConstructionControllerPublic;
use App\Http\Controllers\PublicUser\DashboardControllerPublic;
use App\Http\Controllers\PublicUser\DataDesaCantikController;
use App\Http\Controllers\PublicUser\GalleryControllerPublic;
use App\Http\Controllers\PublicUser\PpidControllerPublic;
use App\Http\Controllers\PublicUser\ProfileControllerPublic;
use App\Http\Controllers\PublicUser\UmkmCommentController;
use App\Http\Controllers\PublicUser\UmkmControllerPublic;
use App\Http\Controllers\PublikasiDesaCantikController;
use App\Http\Controllers\RatingPelayananController;
use App\Http\Controllers\SocialMediaProfileController;
use App\Http\Controllers\StatistikDataController;
use App\Http\Controllers\SubmissionLetter\AdminSuratController;
use App\Http\Controllers\SubmissionLetter\DashboardControllerSubmission;
use App\Http\Controllers\SubmissionLetter\PengajuanController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\UmkmSectorController;
use App\Http\Controllers\VillageProfileController;
use Illuminate\Support\Facades\Route;







Route::get('/launching', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('admin/dashboard/index');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('guest')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::middleware(['conditional_verified'])->group(function () {
    Route::get('/', [DashboardControllerPublic::class, 'index'])->name('show.dashboard');

    // Announcement For Public
    Route::get('/pengumuman', [AnnouncementControllerPublic::class, 'index'])->name('show.announcement');
    Route::get('/pengumuman/{slug}', [AnnouncementControllerPublic::class, 'detail'])->name('show.announcement.detail');

    // Article For Public
    Route::get('/artikel', [ArticleControllerPublic::class, 'index'])->name('show.article');
    Route::get('/artikel/{slug}', [ArticleControllerPublic::class, 'detail'])->name('show.article.detail');

    // Gallery For Public
    Route::get('/galeri', [GalleryControllerPublic::class, 'index'])->name('show.gallery');

    // Construction For Public
    Route::get('/pembangunan', [ConstructionControllerPublic::class, 'index'])->name('show.construction');
    Route::get('/pembangunan/{slug}', [ConstructionControllerPublic::class, 'detail'])->name('show.construction.detail');

    // Umkm For Public
    Route::get('/umkm', [UmkmControllerPublic::class, 'index'])->name('show.umkm.public');
    Route::get('/admin/umkm/{slug}', [UmkmControllerPublic::class, 'details'])->name('show.umkm.details');
    // Umkm Comments
    Route::post('/comments', [UmkmCommentController::class, 'store'])->name('comments.store');

    // Profil desa
    Route::get('/profile-desa', [ProfileControllerPublic::class, 'index'])->name('show.profile.public');

    // PPID desa
    Route::get('/ppid-desa', [PpidControllerPublic::class, 'index'])->name('show.ppid');
    Route::get('/ppid/{ppid}/preview', [PpidControllerPublic::class, 'previewRegulasi'])->name('ppid.preview.public');
    Route::get('/ppid/{ppid}/download', [PpidControllerPublic::class, 'downloadRegulasi'])->name('ppid.download.public');

    //Desa Cantik
    Route::get('/statistik-kependudukan', [DataDesaCantikController::class, 'statistik'])->name('show.desa-cantik.statistik');
    Route::get('/statistik-kependudukan/detail', [DataDesaCantikController::class, 'detailStatistik'])->name('show.desa-cantik.detail-statistik');
    Route::get('/publikasi-desa-cantik', [DataDesaCantikController::class, 'publikasi'])->name('show.desa-cantik.publikasi');
    Route::get('/infografis-desa-cantik', [DataDesaCantikController::class, 'infografis'])->name('show.desa-cantik.infografis');
    Route::get('/kewilayahan', [DataDesaCantikController::class, 'kewilayahan'])->name('show.desa-cantik.kewilayahan');
    Route::get('/pembagian-kewilayahan', [DataDesaCantikController::class, 'kewilayahan2'])->name('show.desa-cantik.kewilayahan2');
    Route::get('/autocomplete', [DataDesaCantikController::class, 'autocomplete'])->name('kewilayahan.autocomplete');
});

Route::middleware(['auth', 'verified'])->group(function () {
     Route::get('/dokumen-surat/{filename}', [AdminSuratController::class, 'showPrivateFile'])
        ->where('filename', '.*') // penting agar nama file yang ada titik tidak error
        ->name('dokumen.surat.show');

    // Detail Surat
    Route::get('/dokumen/{filename}', [AdminSuratController::class, 'detailSyarat'])->name('dokumen.show');
    
    // User Profile
    Route::get('/user/profile', [ProfileController::class, 'edit'])->name('profile-user.edit');
    Route::patch('/user/profile', [ProfileController::class, 'update'])->name('profile-user.update');
    Route::delete('/user/profile', [ProfileController::class, 'destroy'])->name('profile-user.destroy');
    
    // Pelayanan administrasi(Masyarakat)
    Route::get('/pelayanan-administrasi/dashboard', [DashboardControllerSubmission::class, 'index'])->name('show.community-services.dashboard');
    Route::get('/pelayanan-administrasi/dashboard/result', [DashboardControllerSubmission::class, 'result'])->name('show.community-services.result');
    Route::get('/pelayanan-administrasi/pengajuan-saya', [DashboardControllerSubmission::class, 'mySubmissionPage'])->name('show.mysubmission');
    Route::get('/pelayanan-administrasi/pengajuan-saya/{id}', [DashboardControllerSubmission::class, 'myDetailSubmission'])->name('show.mysubmission.detail');
    Route::get('/pelayanan-administrasi/riwayat-pengajuan', [DashboardControllerSubmission::class, 'submissionHistory'])->name('show.historymysubmission');
    Route::get('/download/surat-selesai/{filename}', [DashboardControllerSubmission::class, 'downloadSuratSelesai'])
        ->name('download.surat.selesai');
    // Form Pengajuan
    Route::get('/surat/form/{slug}', [PengajuanController::class, 'form'])->name('pengajuan.form');
    Route::post('/surat/form/save', [PengajuanController::class, 'store'])->name('pengajuan.store');
    // Daftar Pengajuan Saya
    Route::get('/surat/form/{id}', [PengajuanController::class, 'form'])->name('pengajuan.form');

    // Rating Jenis Surat
    Route::post('/rating', [RatingPelayananController::class, 'store'])->name('rating.store');

    // Admin dan Operator
    Route::middleware(['role:admin,operator'])->group(function () {
        // Main Page
        Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/dashboard/pelayanan-surat', [DashboardSubmissionLetterController::class, 'index'])->name('admin.dashboard-submission-letter');


        // PELAYANAN ROUTE
        // Admin Antrian Pengajuan
        Route::get('/admin/surat', [AdminSuratController::class, 'index'])->name('admin.surat.index');
        Route::get('/admin/surat/{id}', [AdminSuratController::class, 'show'])->name('admin.surat.show');
        Route::post('/admin/surat/{id}/status', [AdminSuratController::class, 'updateStatus'])->name('admin.surat.updateStatus');
        Route::post('/admin/surat/{id}/selesai', [AdminSuratController::class, 'kirimSurat'])->name('admin.surat.kirim');

        // Admin Jenis Surat
        Route::prefix('admin/jenis-surat')->name('show.admin.submission_option')->group(function () {
            Route::get('/', [JenisSuratController::class, 'index']);
            Route::get('/form/{id?}', [JenisSuratController::class, 'form'])->name('.form');
            Route::post('/save/{id?}', [JenisSuratController::class, 'storeOrUpdate'])->name('.save');
            Route::delete('/delete/{id?}', [JenisSuratController::class, 'destroy'])->name('.delete');
        });
        // Admin Jenis Surat Syarat
        Route::prefix('admin/jenis-surat/syarat')->name('show.admin.submission_requirements')->group(function () {
            Route::get('/', [JenisSuratSyaratController::class, 'index']);
            Route::get('/form/{id?}', [JenisSuratSyaratController::class, 'syaratForm'])->name('.form');
            Route::post('/save/{id?}', [JenisSuratSyaratController::class, 'storeOrUpdate'])->name('.save');
            Route::delete('/delete/{id?}', [JenisSuratSyaratController::class, 'destroy'])->name('.delete');
        });
        // Notifikasi
        Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('show.notifikasi');
        Route::post('/notifikasi/{id}/mark-read', [NotifikasiController::class, 'markAsRead'])->name('show.notifikasi.read');
        Route::delete('/notifikasi/{id}', [NotifikasiController::class, 'destroy'])->name('show.notifikasi.destroy');
        // Laporan
        // Pengguna
        Route::get('/laporan/pengguna', [LaporanController::class, 'tampilLaporanPengguna'])->name('laporan.pengguna.tampil');
        Route::get('/laporan/pengguna/download', [LaporanController::class, 'downloadPengguna'])->name('laporan.pengguna.download');
        Route::get('/laporan/pengguna/print', [LaporanController::class, 'printPengguna'])->name('laporan.pengguna.print');
        // Pengajuan
        Route::get('/laporan/pengajuan', [LaporanController::class, 'tampilLaporanPengajuan'])->name('laporan.pengajuan.tampil');
        Route::get('/laporan/pengajuan/download', [LaporanController::class, 'downloadPengajuan'])->name('laporan.pengajuan.download');
        Route::get('/laporan/pengajuan/print', [LaporanController::class, 'printPengajuan'])->name('laporan.pengajuan.print');
        // Rekap Bulanan
        Route::get('/laporan/rekap-bulanan', [LaporanController::class, 'tampilLaporanRekapBulanan'])->name('laporan.rekap-bulanan.tampil');
        Route::get('/laporan/rekap-bulanan/download', [LaporanController::class, 'downloadRekap'])->name('laporan.rekap-bulanan.download');
        Route::get('/laporan/rekap-bulanan/print', [LaporanController::class, 'printRekap'])->name('laporan.rekap-bulanan.print');

        

        // Web settings
        // Banner
        Route::get('/admin/setting/banner-list', [BannerImgController::class, 'index'])->name('show.settingBanner');
        Route::get('/admin/setting/banner-form/{id?}', [BannerImgController::class, 'bannerSettingForm'])->name('show.settingBanner.form');
        Route::post('/admin/setting/banner-save', [BannerImgController::class, 'bannerSettingSave'])->name('bannerSettingSave');
        Route::post('/admin/setting/update/{id}', [BannerImgController::class, 'bannerSettingUpdate'])->name('bannerSettingUpdate');
        Route::delete('/admin/setting/delete/{id}', [BannerImgController::class, 'bannerSettingDelete'])->name('banner.delete');
        // Banner Service Page
        Route::get('/admin/setting/banner-service-list', [BannerImgServiceController::class, 'index'])->name('show.setting-banner-service');
        Route::get('/admin/setting/banner-service-form/{id?}', [BannerImgServiceController::class, 'bannerSettingForm'])->name('show.setting-banner-service.form');
        Route::post('/admin/setting/banner-service-save', [BannerImgServiceController::class, 'bannerSettingSave'])->name('show.setting-banner-service.save');
        Route::post('/admin/setting/update-service/{id}', [BannerImgServiceController::class, 'bannerSettingUpdate'])->name('show.setting-banner-service.update');
        Route::delete('/admin/setting/delete-service/{id}', [BannerImgServiceController::class, 'bannerSettingDelete'])->name('show.setting-banner-service.delete');
         
        // Admin User Management
        Route::get('/admin/pengaturan-pengguna', [UserManagementController::class, 'index'])->name('admin.pengguna');
        Route::get('/admin/pengaturan-pengguna/{id}', [UserManagementController::class, 'show'])->name('admin.pengguna.show');
        Route::get('/admin/pengaturan-pengguna/edit/{id}', [UserManagementController::class, 'edit'])->name('admin.pengguna.edit');
        Route::put('/admin/pengaturan-pengguna/update/{id}', [UserManagementController::class, 'update'])->name('admin.pengguna.update');
        Route::delete('/admin/pengaturan-pengguna/hapus/{id}', [UserManagementController::class, 'destroy'])->name('admin.pengguna.destroy');
        


        // PUBLIKASI ROUTE
        // Populations
        Route::get('/admin/data-masyarakat', [PopulationController::class, 'index'])->name('show.populations');
        Route::get('/admin/data-masyarakat/{nik}', [PopulationController::class, 'details'])->name('show.populations.details');
        Route::post('/admin/data-masyarakat/hapus-data/{nik}', [PopulationController::class, 'destroy'])->name('populations.destroy');
        Route::put('/admin/data-masyarakat/restore/{nik}', [PopulationController::class, 'restore'])->name('populations.restore');
        Route::delete('/admin/data-masyarakat/hapus-permanen/{nik}', [PopulationController::class, 'forceDelete'])->name('populations.forceDelete');
        Route::post('/admin/data-masyarakat/kosongkan-data', [PopulationController::class, 'truncate'])->name('populations.truncate');
        // Manajemen Data
        Route::get('/admin/export-excel', [PopulationController::class, 'export'])->name('populations.export');
        Route::get('/admin/download-template-excel', [PopulationController::class, 'downloadTemplate'])->name('populations.downloadtemplate');
        Route::post('/admin/import-excel', [PopulationController::class, 'import'])->name('populations.import');
        Route::get('/admin/invalid-rows', [PopulationController::class, 'showInvalidRows'])->name('populations.invalidrows.show');

        // Announcements
        Route::get('/admin/daftar-pengumuman', [AnnouncementController::class, 'index'])->name('show.announcements');
        Route::get('/admin/daftar-pengumuman/form/{slug?}', [AnnouncementController::class, 'announcementForm'])->name('show.announcements.form');
        Route::post('/admin/daftar-pengumuman/form/save', [AnnouncementController::class, 'save'])->name('announcement.save');
        Route::post('/admin/daftar-pengumuman/form/update/{slug}', [AnnouncementController::class, 'update'])->name('announcement.update');
        Route::delete('/admin/pengumuman/hapus/{slug}', [AnnouncementController::class, 'delete'])->name('announcement.delete');
    
        // Articles
        Route::get('/admin/daftar-artikel', [ArticleController::class, 'index'])->name('show.articles');
        Route::get('/admin/daftar-artikel/form/{slug?}', [ArticleController::class, 'articleForm'])->name('show.articles.form');
        Route::post('/admin/daftar-artikel/form/save', [ArticleController::class, 'save'])->name('article.save');
        Route::post('/admin/daftar-artikel/form/update/{slug}', [ArticleController::class, 'update'])->name('article.update');
        Route::delete('/admin/artikel/{slug}', [ArticleController::class, 'delete'])->name('article.delete');
        // Articles Categories
        Route::post('/admin/article-categories/save', [ArticleCategoryController::class, 'save'])->name('article.category.save');
        Route::post('/admin/article-categories/update/{slug}', [ArticleCategoryController::class, 'update'])->name('article.category.update');
        Route::delete('/admin/article-categories/{slug}', [ArticleCategoryController::class, 'delete'])->name('article.category.delete');
        
        // Constructions
        Route::get('/admin/daftar-pembangunan', [ConstructionController::class, 'index'])->name('show.constructions');
        Route::get('/admin/daftar-pembangunan/form/{slug?}', [ConstructionController::class, 'constructionForm'])->name('show.constructions.form');
        Route::post('/admin/daftar-pembangunan/form/save', [ConstructionController::class, 'save'])->name('construction.save');
        Route::put('/admin/daftar-pembangunan/form/update/{slug}', [ConstructionController::class, 'update'])->name('construction.update');
        Route::delete('/admin/daftar-pembangunan/{slug}', [ConstructionController::class, 'delete'])->name('construction.delete');
        // Construction Documentation
        Route::get('/admin/daftar-pembangunan/dokumentasi-pembangunan/{slug}', [ConstructionDocumentationController::class, 'index'])->name('show.constructions.documentation');
        Route::get('/admin/construction/{slug}/documentation/{id?}', [ConstructionDocumentationController::class, 'constructionDocumentationForm'])->name('show.constructions.documentation.form');
        Route::post('/admin/daftar-pembangunan/dokumentasi-pembangunan/save/{id}', [ConstructionDocumentationController::class, 'save'])->name('construction.documentation.save');
        Route::post('/admin/daftar-pembangunan/dokumentasi-pembangunan/update/{id}', [ConstructionDocumentationController::class, 'update'])->name('construction.documentation.update');
        Route::delete('/admin/daftar-pembangunan/dokumentasi-pembangunan/delete/{id}', [ConstructionDocumentationController::class, 'delete'])->name('construction.documentation.delete');
        // Fund Source
        Route::post('/admin/fund-source/save', [ConstructionFundSourceController::class, 'save'])->name('construction.fund_source.save');
        Route::delete('/admin/fund-source/{slug}', [ConstructionFundSourceController::class, 'delete'])->name('construction.fund_source.delete');

        // Gallery
        Route::get('/admin/daftar-galeri', [GalleryController::class, 'index'])->name('show.galleries');
        Route::get('/admin/daftar-galeri/tambah', [GalleryController::class, 'create'])->name('show.galleries.create');
        Route::post('/admin/daftar-galeri/save', [GalleryController::class, 'save'])->name('gallery.save');
        Route::post('/admin/daftar-galeri/update/{slug}', [GalleryController::class, 'update'])->name('galleries.update');
        Route::post('/admin/galeri', [GalleryController::class, 'deleteSelected'])->name('gallery.delete');

        // Official
        Route::get('/admin/daftar-aparatur', [OfficialController::class, 'index'])->name('show.officials');
        Route::get('/admin/daftar-aparatur/form/{slug?}', [OfficialController::class, 'officialForm'])->name('show.officials.form');
        Route::post('/admin/daftar-aparatur/save', [OfficialController::class, 'save'])->name('official.save');
        Route::post('/admin/daftar-aparatur/update/{slug}', [OfficialController::class, 'update'])->name('official.update');
        Route::delete('/admin/aparatur/{slug}', [OfficialController::class, 'delete'])->name('official.delete');
        Route::get('/admin/daftar-aparatur/detail/{slug}', [OfficialController::class, 'details'])->name('show.official.detail');
        
        // PPID
        Route::get('/admin/ppid', [PpidController::class, 'index'])->name('show.ppid');
        Route::post('/admin/ppid/save', [PpidController::class, 'save'])->name('ppid.save');
        Route::post('/admin/ppid/update/{slug}', [PpidController::class, 'update'])->name('ppid.update');
    
        // UMKM
        Route::get('/admin/daftar-umkm', [UmkmController::class, 'index'])->name('show.umkm');
        Route::get('/admin/daftar-umkm/form/{slug?}', [UmkmController::class, 'umkmForm'])->name('show.umkm.form');
        Route::post('/admin/daftar-umkm/save', [UmkmController::class, 'save'])->name('umkm.save');
        Route::post('/admin/daftar-umkm/update/{slug}', [UmkmController::class, 'update'])->name('umkm.update');
        Route::delete('/admin/umkm/{slug}', [UmkmController::class, 'delete'])->name('umkm.delete');
        // Sector Category
        Route::post('/admin/umkm-sector-categories/save', [UmkmSectorController::class, 'save'])->name('umkm.sector.save');
        Route::put('/admin/umkm-sector-categories/update/{slug}', [UmkmSectorController::class, 'update'])->name('umkm.sector.update');
        Route::delete('/admin/umkm-sector-categories/delete/{slug}', [UmkmSectorController::class, 'destroy'])->name('umkm.sector.delete');

        // Village Profile
        Route::get('/admin/profil-desa', [VillageProfileController::class, 'index'])->name('profile_village.edit');
        Route::put('/admin/profil-desa/save', [VillageProfileController::class, 'save'])->name('profile_village.save');
        Route::put('/admin/profil-desa/update/{id}', [VillageProfileController::class, 'update'])->name('profile_village.update');
        
        // Village Social Media
        Route::get('/admin/social-media/create', [SocialMediaProfileController::class, 'create'])->name('social-media');
        Route::post('/admin/social-media', [SocialMediaProfileController::class, 'store'])->name('social-media.store');

        // PPID
        Route::get('/admin/ppid', [PpidController::class, 'index'])->name('ppid.edit');
        Route::put('/admin/ppid/save', [PpidController::class, 'save'])->name('ppid.save');
        Route::put('/admin/ppid/update/{slug}', [PpidController::class, 'update'])->name('ppid.update');
        Route::get('/admin/ppid/{ppid}/preview', [PpidController::class, 'previewRegulasi'])->name('ppid.preview');
        Route::get('/admin/ppid/{ppid}/download', [PpidController::class, 'downloadRegulasi'])->name('ppid.download');

        // Admin Profile
        Route::get('/admin/profile', [AdminProfileController::class, 'edit'])->name('profile-admin.edit');
        Route::patch('/admin/profile', [AdminProfileController::class, 'update'])->name('profile-admin.update');
        Route::delete('/admin/profile', [AdminProfileController::class, 'destroy'])->name('profile-admin.destroy');

        // Publikasi Desa Cantik
        Route::get('/admin/daftar-publikasi-desa-cantik', [PublikasiDesaCantikController::class, 'index'])->name('show.admin.desa-cantik.publikasi');
        Route::get('/admin/daftar-publikasi-desa-cantik/form/{slug?}', [PublikasiDesaCantikController::class, 'desaCantikForm'])->name('show.admin.desa-cantik.publikasi.form');
        Route::post('/admin/daftar-publikasi-desa-cantik/save', [PublikasiDesaCantikController::class, 'save'])->name('publikasi-desa-cantik.save');
        Route::post('/admin/daftar-publikasi-desa-cantik/update/{slug}', [PublikasiDesaCantikController::class, 'update'])->name('publikasi-desa-cantik.update');
        Route::delete('/admin/publikasi-desa-cantik/{slug}', [PublikasiDesaCantikController::class, 'delete'])->name('publikasi-desa-cantik.delete');
        Route::get('/admin/daftar-publikasi-desa-cantik/detail/{slug}', [PublikasiDesaCantikController::class, 'details'])->name('show.admin.desa-cantik.publikasi.detail');
    
        // Publikasi Desa Cantik
        Route::get('/admin/daftar-infografis-desa-cantik', [InfografisController::class, 'index'])->name('show.admin.desa-cantik.infografis');
        Route::get('/admin/daftar-infografis-desa-cantik/form/{id?}', [InfografisController::class, 'infografisForm'])->name('show.admin.desa-cantik.infografis.form');
        Route::post('/admin/daftar-infografis-desa-cantik/save', [InfografisController::class, 'save'])->name('infografis-desa-cantik.save');
        Route::post('/admin/daftar-infografis-desa-cantik/update/{id}', [InfografisController::class, 'update'])->name('infografis-desa-cantik.update');
        Route::delete('/admin/infografis-desa-cantik/{id}', [InfografisController::class, 'delete'])->name('infografis-desa-cantik.delete');
        Route::get('/admin/daftar-infografis-desa-cantik/detail/{id}', [InfografisController::class, 'details'])->name('show.admin.desa-cantik.infografis.detail');
        
        // Kewilayahan Desa Cantik
        Route::get('/admin/daftar-kewilayahan-desa-cantik', [KewilayahanDesaCantikController::class, 'index'])->name('show.admin.desa-cantik.kewilayahan');
        Route::get('/admin/daftar-kewilayahan-desa-cantik/form/{id?}', [KewilayahanDesaCantikController::class, 'kewilayahanForm'])->name('show.admin.desa-cantik.kewilayahan.form');
        Route::post('/admin/daftar-kewilayahan-desa-cantik/save', [KewilayahanDesaCantikController::class, 'save'])->name('kewilayahan-desa-cantik.save');
        Route::post('/admin/daftar-kewilayahan-desa-cantik/update/{id}', [KewilayahanDesaCantikController::class, 'update'])->name('kewilayahan-desa-cantik.update');
        Route::delete('/admin/kewilayahan-desa-cantik/{id}', [KewilayahanDesaCantikController::class, 'delete'])->name('kewilayahan-desa-cantik.delete');
        Route::get('/admin/daftar-kewilayahan-desa-cantik/detail/{id}', [KewilayahanDesaCantikController::class, 'details'])->name('show.admin.desa-cantik.kewilayahan.detail');
        // Kewilayahan2
        Route::get('/admin/daftar-pembagian-kewilayahan-desa-cantik', [Kewilayahan2Controller::class, 'index'])->name('show.admin.desa-cantik.pembagian-kewilayahan');
        Route::get('/admin/daftar-pembagian-kewilayahan-desa-cantik/form/{id?}', [Kewilayahan2Controller::class, 'kewilayahanForm'])->name('show.admin.desa-cantik.kewilayahan2.form');
        Route::post('/admin/daftar-pembagian-kewilayahan-desa-cantik/save', [Kewilayahan2Controller::class, 'saveOrUpdate'])->name('kewilayahan2-desa-cantik.saveOrUpdate');
        // Route::post('/admin/daftar-pembagian-kewilayahan-desa-cantik/update/{id}', [Kewilayahan2Controller::class, 'update'])->name('kewilayahan2-desa-cantik.update');
        Route::delete('/admin/pembagian-kewilayahan-desa-cantik/{id}', [Kewilayahan2Controller::class, 'destroy'])->name('kewilayahan2-desa-cantik.delete');
        Route::get('/admin/daftar-pembagian-kewilayahan-desa-cantik/detail/{id}', [Kewilayahan2Controller::class, 'details'])->name('show.admin.desa-cantik.kewilayahan2.detail');
        // Sector Category
        Route::post('/admin/kategori-kewilayahan/save', [KewilayahanKategoriController::class, 'save'])->name('kategori-kewilayahan-desa-cantik.save');
        Route::put('/admin/kategori-kewilayahan/update/{slug}', [KewilayahanKategoriController::class, 'update'])->name('kategori-kewilayahan-desa-cantik.update');
        Route::delete('/admin/kategori-kewilayahan/delete/{slug}', [KewilayahanKategoriController::class, 'destroy'])->name('kategori-kewilayahan-desa-cantik.delete');

        // Data dan Statistik
        Route::get('/admin/data-statistik-desa-cantik', [StatistikDataController::class, 'index'])->name('show.admin.desa-cantik.data-statistik');
        Route::post('/admin/data-penduduk-import', [StatistikDataController::class, 'importDataPenduduk'])->name('data-penduduk.import');
        Route::post('/admin/data-dusun-import', [StatistikDataController::class, 'importDataDusun'])->name('data-dusun.import');
        Route::post('/admin/data-usia-import', [StatistikDataController::class, 'importDataUsia'])->name('data-usia.import');
        Route::post('/admin/data-pendidikan-import', [StatistikDataController::class, 'importDataPendidikan'])->name('data-pendidikan.import');
        Route::post('/admin/data-pekerjaan-import', [StatistikDataController::class, 'importDataPekerjaan'])->name('data-pekerjaan.import');
        Route::post('/admin/data-agama-import', [StatistikDataController::class, 'importDataAgama'])->name('data-agama.import');
        Route::post('/admin/data-kewarganegaraan-import', [StatistikDataController::class, 'importDataKewarganegaraan'])->name('data-kewarganegaraan.import');
        Route::post('/admin/data-jenis-cacat-import', [StatistikDataController::class, 'importDataJenisCacat'])->name('data-jenis-cacat.import');
        Route::post('/admin/data-tenaga-kerja-import', [StatistikDataController::class, 'importDataTenagaKerja'])->name('data-tenaga-kerja.import');
        Route::post('/admin/data-ekonomi-import', [StatistikDataController::class, 'importDataEkonomi'])->name('data-ekonomi.import');
        
    });
});

require __DIR__.'/auth.php';
