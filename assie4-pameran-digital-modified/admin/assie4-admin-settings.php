<?php
/**
 * Admin Settings — ASSIE IV Pameran Digital v2.7
 * Semua halaman admin bersih, konsisten, CSS dari file eksternal
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/* ═══ OPTION KEYS ═══════════════════════════════════════ */
define( 'ASSIE4_OPT_INFO',    'assie4_pameran_info'    );
define( 'ASSIE4_OPT_SLIDES',  'assie4_pameran_slides'  );
define( 'ASSIE4_OPT_TICKER',  'assie4_pameran_ticker'  );
define( 'ASSIE4_OPT_RUNDOWN', 'assie4_pameran_rundown' );
define( 'ASSIE4_OPT_TENANTS', 'assie4_pameran_tenants' );

/* ═══ NORMALIZE TENANT ══════════════════════════════════ */
function assie4_normalize_tenant( $t ) {
    $t = (array) $t;
    return [
        'id'        => sanitize_key( trim( $t['id']        ?? '' ) ),
        'booth_no'  => intval( $t['booth_no'] ?? 0 ),
        'code'      => strtoupper( sanitize_text_field( trim( $t['code'] ?? $t['id'] ?? '' ) ) ),
        'cluster'   => intval( $t['cluster'] ?? 0 ),
        'area'      => strtoupper( sanitize_text_field( trim( $t['area'] ?? 'A' ) ) ),
        'name'      => sanitize_text_field( trim( $t['name']      ?? '' ) ),
        'instansi'  => sanitize_text_field( trim( $t['instansi']  ?? '' ) ),
        'pic'       => sanitize_text_field( trim( $t['pic']       ?? '' ) ),
        'cat'       => sanitize_text_field( trim( $t['cat']       ?? '' ) ),
        'desc'      => sanitize_textarea_field( trim( $t['desc']  ?? '' ) ),
        'tags'      => is_array( $t['tags']  ?? null )
                        ? array_map('sanitize_text_field', $t['tags'])
                        : array_values( array_filter( array_map( 'trim', explode( ',', sanitize_text_field($t['tags'] ?? '') ) ) ) ),
        'logo'      => esc_url_raw( trim( $t['logo']      ?? '' ) ),
        'contact'   => sanitize_text_field( trim( $t['contact']   ?? '' ) ),
        'whatsapp'  => sanitize_text_field( trim( $t['whatsapp']  ?? '' ) ),
        'web'       => esc_url_raw( trim( $t['web']       ?? '' ) ),
        'instagram' => sanitize_text_field( trim( $t['instagram'] ?? '' ) ),
        'facebook'  => esc_url_raw( trim( $t['facebook']  ?? '' ) ),
        'twitter'   => sanitize_text_field( trim( $t['twitter']   ?? '' ) ),
        'transaksi' => sanitize_text_field( trim( $t['transaksi'] ?? '' ) ),
    ];
}

/* ═══ DEFAULT DATA ══════════════════════════════════════ */
function assie4_default_info() {
    return [ 'date'=>'6-8 November 2026', 'location'=>'Grand City Atrium, Surabaya', 'org'=>'PASINBIS Universitas Airlangga', 'timeOpen'=>'10:00', 'timeClose'=>'22:00', 'logo'=>ASSIE4_PAMERAN_URL . 'assets/logo-assie4.png' ];
}
function assie4_default_slides() {
    return [
        [
            'title'    => 'ASSIE IV 2026',
            'subtitle' => 'Airlangga Startup Summit & Innovation Expo',
            'desc'     => 'Ajang pameran startup & inovasi terbesar di Jawa Timur.',
            'cta'      => 'Jelajahi Pameran',
            'link'     => '#denah',
            'bg'       => ASSIE4_PAMERAN_URL . 'assets/kegiatan-assie-1.jpg',
        ],
        [
            'title'    => 'Inovasi Tanpa Batas',
            'subtitle' => 'Grand City Atrium · Surabaya',
            'desc'     => 'Temui inovator muda dan ekosistem startup Jawa Timur.',
            'cta'      => 'Lihat Denah Booth',
            'link'     => '#denah',
            'bg'       => ASSIE4_PAMERAN_URL . 'assets/kegiatan-assie-4.jpg',
        ],
        [
            'title'    => 'Dukung Startup Lokal',
            'subtitle' => 'TokoUA · tokoua.unair.ac.id',
            'desc'     => 'Beli produk tenant pameran secara online melalui TokoUA.',
            'cta'      => 'Kunjungi TokoUA',
            'link'     => 'https://tokoua.unair.ac.id/',
            'bg'       => ASSIE4_PAMERAN_URL . 'assets/kegiatan-assie-3.jpg',
        ],
        [
            'title'    => 'Kompetisi & Talenta Digital',
            'subtitle' => 'Roblox & E-Sport Competition · Grand City Atrium',
            'desc'     => 'Wadah kreativitas talenta digital dan generasi inovator masa depan.',
            'cta'      => 'Lihat Rundown Acara',
            'link'     => '#rundown',
            'bg'       => ASSIE4_PAMERAN_URL . 'assets/kegiatan-assie-2.jpg',
        ],
        [
            'title'    => 'Industry Matching',
            'subtitle' => 'ASSIE IV 2026',
            'desc'     => '',
            'cta'      => '',
            'link'     => '#denah',
            'bg'       => ASSIE4_PAMERAN_URL . 'assets/kegiatan-assie-5.jpg',
            'logo'     => ASSIE4_PAMERAN_URL . 'assets/logo-assie4.png',
            'is_logo'  => true,
        ],
    ];
}
function assie4_default_ticker() {
    return ['Selamat datang di ASSIE IV 2026','6-8 November 2026 · Grand City Atrium Surabaya','Booth startup & inovasi','Belanja produk tenant online di tokoua.unair.ac.id','Presensi digital tersedia di setiap booth','PASINBIS Universitas Airlangga'];
}
function assie4_default_tenants() {
    return [
        [
            'id'        => 'a1',
            'booth_no'  => 1,
            'code'      => 'A1',
            'cluster'   => 1,
            'area'      => 'A',
            'name'      => 'Fakultas Kedokteran',
            'instansi'  => 'Fakultas Kedokteran',
            'pic'       => 'Reny I\'tishom',
            'cat'       => 'Internal UNAIR',
            'desc'      => 'Fakultas Kedokteran Universitas Airlangga (FK Unair) di Surabaya merupakan salah satu fakultas kedokteran tertua dan paling bersejarah di Indonesia. Sejarahnya berakar dari tradisi pendidikan medis era Hindia Belanda yang diawali oleh pencerahan Sekolah Dokter Jawa pada pertengahan abad ke-19.

Secara resmi, cikal bakal FK Unair berdiri pada 1 November 1913 di Surabaya dengan nama NIAS (Nederlandsch Indische Artsen School). Lembaga ini mencetak para dokter pribumi yang berperan besar dalam pelayanan kesehatan dan pergerakan nasional. Memasuki masa pendudukan Jepang, NIAS berganti nama menjadi Surabaya Ika Daigaku. Setelah kemerdekaan, sekolah ini sempat berstatus sebagai cabang Fakultas Kedokteran Universitas Indonesia (FK UI) sebelum akhirnya diresmikan oleh Presiden Soekarno menjadi bagian dari Universitas Airlangga pada 10 November 1954.

Saat ini, FK Unair menjadi salah satu pusat pendidikan kedokteran unggulan berakreditasi internasional di Indonesia. Didukung oleh jaringan rumah sakit pendidikan utama seperti RSUD Dr. Soetomo dan Rumah Sakit Universitas Airlangga (RSUA), FK Unair terus melahirkan tenaga medis bertaraf global, memperkuat riset kesehatan, dan menjaga warisan sejarahnya sebagai pilar kedokteran tanah air.',
            'tags'      => ['Internal UNAIR', 'UNAIR', 'Transaksi Booth'],
            'logo'      => 'https://drive.google.com/drive/folders/1RjUz0bE9UJKDOusL3GefYSQsSCsjaZmA?usp=sharing',
            'contact'   => 'ritishom@fk.unair.ac.id & humas@fk.unair.ac.id',
            'whatsapp'  => '08121644432 & 085961510996',
            'web'       => 'https://fk.unair.ac.id/',
            'instagram' => 'instagram.com/fk_unair',
            'facebook'  => 'facebook.com/MedicineUNAIR',
            'twitter'   => 'x.com/FK_UNAIR_ofc',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'a2',
            'booth_no'  => 2,
            'code'      => 'A2',
            'cluster'   => 1,
            'area'      => 'A',
            'name'      => 'Fakultas Kedokteran Gigi Universitas Airlangga',
            'instansi'  => 'Fakultas Kedokteran Gigi Universitas Airlangga',
            'pic'       => 'Dr. Andari Sarasati drg.',
            'cat'       => 'Internal UNAIR',
            'desc'      => 'FKG UNAIR merupakan institusi pendidikan kedokteran gigi unggulan di Indonesia dengan kekuatan dalam pendidikan, riset, inovasi, dan pengabdian masyarakat. Berbagai riset dan inovasi produk dikembangkan untuk menghasilkan solusi kesehatan gigi dan mulut  yang berdampak dan berpotensi dikolaborasikan serta dihilirkan bersama industri dan pemerintah.',
            'tags'      => ['Internal UNAIR', 'UNAIR', 'Transaksi Booth'],
            'logo'      => 'https://drive.google.com/drive/folders/1vaiAIwr_7r_jFDA6vT-IJMS_IIyUT_41?usp=sharing',
            'contact'   => 'andari.sarasati@fkg.unair.ac.id',
            'whatsapp'  => '81333343938.0',
            'web'       => 'https://unair.ac.id/fakultas-kedokteran-gigi/',
            'instagram' => 'Dental Medicine UNAIR (@fkg.unair)',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'a3',
            'booth_no'  => 3,
            'code'      => 'A3',
            'cluster'   => 1,
            'area'      => 'A',
            'name'      => 'Fakultas Farmasi UNAIR',
            'instansi'  => 'Fakultas Farmasi UNAIR',
            'pic'       => 'Yusuf Alif Pratama',
            'cat'       => 'Internal UNAIR',
            'desc'      => 'Produk inovasi FF UNAIR',
            'tags'      => ['Internal UNAIR', 'UNAIR', 'Transaksi Booth'],
            'logo'      => 'https://drive.google.com/drive/folders/1Pazt80IK4yX47K9C2G6LF9T4en_XePL3?usp=sharing',
            'contact'   => 'yusuf.alif@ff.unair.ac.id',
            'whatsapp'  => '089605257473',
            'web'       => 'https://ff.unair.ac.id',
            'instagram' => 'ff.unair',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'a4',
            'booth_no'  => 4,
            'code'      => 'A4',
            'cluster'   => 1,
            'area'      => 'A',
            'name'      => 'Fakultas Kedokteran Hewan Universitas Airlangga',
            'instansi'  => 'Fakultas Kedokteran Hewan Universitas Airlangga',
            'pic'       => 'Dhandy Koesoemo Wardhana, drh.,M.Vet.,Ph.D',
            'cat'       => 'Internal UNAIR',
            'desc'      => 'Fakultas Kedokteran Hewan Universitas Airlangga (FKH UNAIR) merupakan salah satu institusi pendidikan kedokteran hewan terkemuka di Indonesia yang unggul dalam pendidikan, penelitian, dan pengabdian kepada masyarakat. Didukung sumber daya akademik yang kompeten, fasilitas pendidikan dan penelitian yang memadai, serta jejaring kerja sama nasional dan internasional, FKH UNAIR berkomitmen menghasilkan lulusan dan inovasi yang berdaya saing serta berkontribusi nyata bagi kesehatan hewan dan kesehatan masyarakat. Arah penelitian FKH UNAIR diselaraskan dengan rencana pengembangan institusi, kebutuhan nasional, dan tren global, dengan orientasi utama pada penelitian terapan yang berujung pada hilirisasi. Melalui riset yang berorientasi produk, FKH UNAIR mendorong lahirnya luaran kekayaan intelektual, khususnya paten dan paten sederhana yang aplikatif dan siap dimanfaatkan pengguna, mulai dari kandidat vaksin, kit diagnostik, sediaan obat hewan dan herbal, hingga teknologi reproduksi dan pakan fungsional. Luaran tersebut dikembangkan bersama mitra industri, pemerintah, dan masyarakat agar tidak berhenti sebagai publikasi ilmiah, melainkan bertransformasi menjadi produk dan layanan yang memberi manfaat ekonomi dan sosial secara langsung.',
            'tags'      => ['Internal UNAIR', 'UNAIR', 'Transaksi Booth'],
            'logo'      => 'https://lh3.googleusercontent.com/d/1JvttX_5s9zKZtkHSoPeNFvegd-kHZ6DB',
            'contact'   => 'dhandy.koesoemo.wardhana@fkh.unair.ac.id',
            'whatsapp'  => '081553121891',
            'web'       => 'https://fkh.unair.ac.id/',
            'instagram' => 'humasfkhunair',
            'facebook'  => '',
            'twitter'   => 'FkhUnair',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'a5',
            'booth_no'  => 5,
            'code'      => 'A5',
            'cluster'   => 1,
            'area'      => 'A',
            'name'      => 'FaST_Booth',
            'instansi'  => 'Fakultas Sains dan Teknologi UNAIR',
            'pic'       => 'Dr. M. Fariz Fadillah Mardianto, M.Si',
            'cat'       => 'Internal UNAIR',
            'desc'      => 'Booth memamerkan karya inovasi dosen Fakultas Sains dan Teknologi Universitas Airlangga dari hasil riset dan pengabdian masyarakat yang berpotensi untuk dikembangkan dalam hilirisasi untuk keberlanjutan',
            'tags'      => ['Internal UNAIR', 'UNAIR', 'Transaksi Booth'],
            'logo'      => 'https://lh3.googleusercontent.com/d/16pnKSNhWIJ7EZlkAIzT34TzBZmLM0k6K',
            'contact'   => 'm.fariz.fadillah.m@fst.unair.ac.id',
            'whatsapp'  => '081330733130',
            'web'       => 'https://fst.unair.ac.id/',
            'instagram' => '@fst_unair',
            'facebook'  => 'Fst Unair',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'a6',
            'booth_no'  => 6,
            'code'      => 'A6',
            'cluster'   => 1,
            'area'      => 'A',
            'name'      => 'FTMM UNAIR',
            'instansi'  => 'FTMM UNAIR',
            'pic'       => 'Vinanci Intan Widriani, S.M.',
            'cat'       => 'Internal UNAIR',
            'desc'      => 'Produk inovasi dari Fakultas Teknologi Maju dan Multidisiplin',
            'tags'      => ['Internal UNAIR', 'UNAIR', 'Transaksi Booth'],
            'logo'      => 'https://ftmm.click/LogoFTMM',
            'contact'   => 'vinanci@staf.unair.ac.id',
            'whatsapp'  => '0822-3216-6441',
            'web'       => 'https://ftmm.unair.ac.id/',
            'instagram' => 'ftmmunair',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'a7',
            'booth_no'  => 7,
            'code'      => 'A7',
            'cluster'   => 1,
            'area'      => 'A',
            'name'      => 'Fakultas Vokasi (Departemen Kesehatan)',
            'instansi'  => 'Universitas Airlangga/ Fakultas Vokasi/ Departemen Kesehatan',
            'pic'       => 'IIF HANIFA NURROSYIDAH',
            'cat'       => 'Internal UNAIR',
            'desc'      => 'Booth ini menampilkan hasil riset, karya inovasi, dan produk praktikum mahasiswa dari Departemen Kesehatan dan Fakultas Vokasi, mencakup Program Studi Pengobatan Tradisional, Radiologi, Teknik Gigi, dan program studi kesehatan lainnya. Pengunjung dapat menyaksikan langsung berbagai inovasi di bidang kesehatan, mulai dari produk herbal dan terapi tradisional berbasis bukti ilmiah, teknologi pencitraan radiologi, hasil karya teknik gigi (protesa, alat orthodontik, dan model anatomi gigi), hingga inovasi alat kesehatan penunjang lainnya. Booth ini menjadi bukti nyata kontribusi dunia pendidikan vokasi kesehatan dalam menghadirkan solusi aplikatif yang siap dihilirisasi ke masyarakat dan industri.',
            'tags'      => ['Internal UNAIR', 'UNAIR', 'Transaksi Booth'],
            'logo'      => 'https://lh3.googleusercontent.com/d/1l0V5h9p4b4SVJjB4aRAmwj5zxfitwSll',
            'contact'   => 'hanifa.nurrosyidah@vokasi.unair.ac.id',
            'whatsapp'  => '085190648711',
            'web'       => '',
            'instagram' => '',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'a8',
            'booth_no'  => 8,
            'code'      => 'A8',
            'cluster'   => 1,
            'area'      => 'A',
            'name'      => 'FPK UNAIR',
            'instansi'  => 'Fakultas Perikanan dan Kelautan Universitas Airlangga',
            'pic'       => 'Daruti Dinda Nindarwi',
            'cat'       => 'Internal UNAIR',
            'desc'      => 'FPK UNAIR menghadirkan inovasi berbasis riset perikanan dan kelautan untuk menciptakan produk bernilai tambah dan berkelanjutan. Melalui kolaborasi antara ilmu pengetahuan, teknologi, dan industri, FPK UNAIR mendorong hilirisasi inovasi untuk menjawab kebutuhan masyarakat dan membuka peluang pengembangan bisnis masa depan.',
            'tags'      => ['Internal UNAIR', 'UNAIR', 'Transaksi Booth'],
            'logo'      => 'https://lh3.googleusercontent.com/d/1kiekoQRRoteyVRfnz7OVGpyXpqKG9zj6',
            'contact'   => 'daruti-dinda-n@fpk.unair.ac.id',
            'whatsapp'  => '+62 822-3172-4191',
            'web'       => 'https://fpk.unair.ac.id',
            'instagram' => 'fpkunair',
            'facebook'  => 'Fakultas Perikanan dan Kelautan',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'a9',
            'booth_no'  => 9,
            'code'      => 'A9',
            'cluster'   => 1,
            'area'      => 'A',
            'name'      => 'Fakultas Ekonomi dan Bisnis',
            'instansi'  => 'Fakultas Ekonomi dan Bisnis Universitas Airlangga',
            'pic'       => '',
            'cat'       => 'Internal UNAIR',
            'desc'      => 'Booth resmi Fakultas Ekonomi dan Bisnis (FEB) Universitas Airlangga.',
            'tags'      => ['Internal UNAIR', 'UNAIR'],
            'logo'      => 'https://unair.ac.id/wp-content/uploads/2021/04/Logo-Universitas-Airlangga-UNAIR-300x300.png',
            'contact'   => '',
            'whatsapp'  => '',
            'web'       => 'https://feb.unair.ac.id/',
            'instagram' => '',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => '',
        ],
        [
            'id'        => 'a10',
            'booth_no'  => 10,
            'code'      => 'A10',
            'cluster'   => 1,
            'area'      => 'A',
            'name'      => 'Public Health UNAIR',
            'instansi'  => 'Fakultas Kesehatan Masyarakat UNAIR',
            'pic'       => 'Rizna Notarianti',
            'cat'       => 'Internal UNAIR',
            'desc'      => 'Booth Public Health UNAIR merupakan ruang yang memperkenalkan dan memasarkan berbagai produk inovasi karya dosen dan mahasiswa Fakultas Kesehatan Masyarakat Universitas Airlangga. Booth ini menghadirkan beragam inovasi di bidang gizi dan kesehatan masyarakat yang dikembangkan berdasarkan kreativitas, keilmuan, serta kebutuhan masyarakat.

Melalui produk-produk yang ditawarkan, Booth FKM UNAIR menjadi wadah untuk mempertemukan hasil inovasi akademik dengan masyarakat secara lebih luas. Setiap produk diharapkan tidak hanya memiliki nilai guna dan nilai ekonomi, tetapi juga memberikan kontribusi nyata dalam mendukung peningkatan kualitas kesehatan dan kesejahteraan masyarakat.

Dengan semangat “Dari Kampus untuk Masyarakat”, Booth FKM UNAIR hadir sebagai representasi kreativitas dan inovasi sivitas akademika FKM UNAIR, sekaligus mendorong pemanfaatan hasil karya dosen dan mahasiswa agar dapat memberikan dampak positif bagi masyarakat.',
            'tags'      => ['Internal UNAIR', 'UNAIR', 'Transaksi Booth'],
            'logo'      => 'https://fkm.unair.ac.id/download/logo-fkm/',
            'contact'   => 'riznanotarianti@fkm.unair.ac.id',
            'whatsapp'  => '081904251396',
            'web'       => '',
            'instagram' => '',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'a11',
            'booth_no'  => 11,
            'code'      => 'A11',
            'cluster'   => 1,
            'area'      => 'A',
            'name'      => 'FIB UNAIR',
            'instansi'  => 'FIB UNAIR BERBUDI DAN BERBUDAYA',
            'pic'       => 'Nuri Hermawan',
            'cat'       => 'Internal UNAIR',
            'desc'      => 'FIB UNAIR mengusung pameran inovsi berbasih budaya. Selain itu, inovasi ditujukan untuk memberikan edukasi dan pemahaman yang komprehensif berkenaan dengan budi dan budaya.',
            'tags'      => ['Internal UNAIR', 'UNAIR', 'Transaksi Booth'],
            'logo'      => 'https://fib.unair.ac.id/fib/download/logo-fib-unair/',
            'contact'   => 'nuri.hermawan@fib.unair.ac.id',
            'whatsapp'  => '085736753801',
            'web'       => 'https://fib.unair.ac.id/fib-main/',
            'instagram' => 'https://www.instagram.com/fib.unair/?hl=en',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'a12',
            'booth_no'  => 12,
            'code'      => 'A12',
            'cluster'   => 1,
            'area'      => 'A',
            'name'      => 'FIKKIA UNAIR',
            'instansi'  => 'FIKKIA UNAIR',
            'pic'       => 'Bintang Gumilang',
            'cat'       => 'Internal UNAIR',
            'desc'      => 'Produk inovasi mahasiswa dan dosen di Fakultas Ilmu Kesehatan, Kedokteran, dan Ilmu Alam Universitas Airlangga',
            'tags'      => ['Internal UNAIR', 'UNAIR', 'Transaksi Booth'],
            'logo'      => 'https://drive.google.com/drive/folders/1KNfH9f7irF8D4H4H6qovC-HvREDT3Pnq?usp=sharing',
            'contact'   => 'bintang.gumilang@staf.unair.ac.id',
            'whatsapp'  => '08980614045',
            'web'       => 'https://fikkia.unair.ac.id',
            'instagram' => 'fikkia.unair',
            'facebook'  => 'fikkia univ airlangga',
            'twitter'   => 'fikkia_unair',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'a16',
            'booth_no'  => 16,
            'code'      => 'A16',
            'cluster'   => 1,
            'area'      => 'A',
            'name'      => 'Lembaga Penyakit Tropis Universitas Airlangga',
            'instansi'  => 'Lembaga Penyakit Tropis Universitas Airlangga',
            'pic'       => 'Laura Navika Yamani',
            'cat'       => 'Internal UNAIR',
            'desc'      => 'Lembaga Penyakit Tropis (LPT) Universitas Airlangga merupakan pusat unggulan penelitian dan pengembangan dalam bidang penyakit tropis dan penyakit infeksi yang mengintegrasikan riset, inovasi, layanan, pendidikan, serta pengembangan produk kesehatan. LPT UNAIR melalui berbagai research center, termasuk Research Center for Global Emerging and Re-emerging Infectious Diseases (RC GERID), mengembangkan penelitian berbasis epidemiologi, biologi molekuler, mikrobiologi, genomik, bioinformatika, dan kesehatan masyarakat untuk menghasilkan produk dan teknologi kesehatan, seperti kit diagnostik, metode deteksi molekuler, primer dan probe, sistem surveilans, serta inovasi untuk pencegahan dan pengendalian penyakit infeksi. Dengan jejaring kolaborasi nasional dan internasional serta kemitraan dengan pemerintah, industri, dan fasilitas pelayanan kesehatan, LPT UNAIR mendorong pendekatan from research to product dan hilirisasi hasil penelitian sehingga dapat memberikan kontribusi nyata terhadap kemandirian teknologi kesehatan, penguatan surveilans penyakit infeksi, dan kesiapsiagaan menghadapi penyakit emerging, re-emerging, dan ancaman pandemi.',
            'tags'      => ['Internal UNAIR', 'UNAIR', 'Transaksi Booth'],
            'logo'      => 'https://lh3.googleusercontent.com/d/1gXojQo-ohtRGaGAuEnwDoCXBgfUeARXf',
            'contact'   => 'laura.navika@fkm.unair.ac.id',
            'whatsapp'  => '085649152890',
            'web'       => 'https://itd.unair.ac.id/wp/',
            'instagram' => 'https://www.instagram.com/itd_unair/',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'a17',
            'booth_no'  => 17,
            'code'      => 'A17',
            'cluster'   => 1,
            'area'      => 'A',
            'name'      => 'Airlangga Enterprise',
            'instansi'  => 'Airlangga Enterprise',
            'pic'       => 'Rio Yuniar Dwinanta',
            'cat'       => 'Internal UNAIR',
            'desc'      => 'Booth Airlangga Enterprise akan menampilkan produk Amerta Water dan ruangan yang disewakan melalui Ditpilar Universitas Airlangga.',
            'tags'      => ['Internal UNAIR', 'UNAIR', 'Transaksi Booth'],
            'logo'      => 'https://lh3.googleusercontent.com/d/1veizQquD1f2unGCUIrSOFUTI6AXYNoim',
            'contact'   => 'rio.yuniar2406@gmail.com',
            'whatsapp'  => '+6282257814415',
            'web'       => 'https://airlanggaenterprise.unair.ac.id',
            'instagram' => 'airlangga_enterprise',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'a18',
            'booth_no'  => 18,
            'code'      => 'A18',
            'cluster'   => 1,
            'area'      => 'A',
            'name'      => 'Dormitory Center',
            'instansi'  => 'Dormitory Center',
            'pic'       => 'Aria Heru Setiawan',
            'cat'       => 'Internal UNAIR',
            'desc'      => 'Pusat Asrama Mahasiswa Universitas Airlangga merupakan fasilitas hunian mahasiswa yang nyaman, aman, dan mendukung pengembangan karakter serta kompetensi. Berlokasi di Kampus C UNAIR, asrama menjadi ruang tumbuh bagi mahasiswa melalui berbagai kegiatan edukatif dan pengembangan diri.',
            'tags'      => ['Internal UNAIR', 'UNAIR', 'Transaksi Booth'],
            'logo'      => 'https://lh3.googleusercontent.com/d/1ZYRj0TBpSGaaBBMswT0JeGrgIiP40OfD',
            'contact'   => 'ariaheru@staf.unair.ac.id',
            'whatsapp'  => '08819301869',
            'web'       => 'https://asrama.unair.ac.id',
            'instagram' => 'dormitoryunair',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'a19',
            'booth_no'  => 19,
            'code'      => 'A19',
            'cluster'   => 1,
            'area'      => 'A',
            'name'      => 'PUSPAS UNAIR',
            'instansi'  => 'Pusat Pengelolaan Dana Sosial',
            'pic'       => 'Nikmatul Fuadah',
            'cat'       => 'Internal UNAIR',
            'desc'      => 'MEnampilkan pengembangan bisnis dari pengelolaan wakaf produktif',
            'tags'      => ['Internal UNAIR', 'UNAIR', 'Transaksi Booth'],
            'logo'      => 'https://drive.google.com/drive/folders/1p7bxF0q4YpaRJuk2nqsMgYsOGi3ux2Qg?usp=sharing',
            'contact'   => 'info@puspas.unair.ac.id',
            'whatsapp'  => '081327976923',
            'web'       => 'https://puspas.unair.ac.id',
            'instagram' => '@puspasunair_official',
            'facebook'  => 'pusat pengelolaan dana sosial universitas airlangga',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'a20',
            'booth_no'  => 20,
            'code'      => 'A20',
            'cluster'   => 1,
            'area'      => 'A',
            'name'      => 'PUSAT HALAL UNIVERSITAS AIRLANGGA',
            'instansi'  => 'PUSAT HALAL UNIVERSITAS HALAL - Menjamin Kehalalan, Memastikan Kebaikan',
            'pic'       => 'Muhammad Risqi Ihya Ramdhan',
            'cat'       => 'Internal UNAIR',
            'desc'      => 'Pusat Halal atau sebelumnya dikenal sebagai Pusat Riset dan Pengembangan Produk Halal Universitas Airlangga (PRPPH UNAIR) dibentuk untuk menjalankan fungsi sebagai Halal Research Center (Pusat Kajian Halal) sekaligus Halal Center, guna mendukung peran aktif institusi perguruan tinggi, khususnya dalam bidang penelitian dan pengabdian kepada masyarakat.',
            'tags'      => ['Internal UNAIR', 'UNAIR', 'Transaksi Booth'],
            'logo'      => 'https://lh3.googleusercontent.com/d/1QhrQOlD8MHaT-ThfncS2Wz0Ut26R3ZKa',
            'contact'   => 'info@halal.unair.ac.id',
            'whatsapp'  => '089697458211',
            'web'       => 'https://halal.unair.ac.id/',
            'instagram' => 'https://www.instagram.com/halalunair/',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'a21',
            'booth_no'  => 21,
            'code'      => 'A21',
            'cluster'   => 1,
            'area'      => 'A',
            'name'      => 'Pusat Bahasa dan Multibudaya',
            'instansi'  => 'Pusat Bahasa dan Multibudaya',
            'pic'       => 'Iyun Witari',
            'cat'       => 'Internal UNAIR',
            'desc'      => '*Pusat Bahasa dan Multibudaya (Pusbamulya) Universitas Airlangga* merupakan unit penunjang penyeleggara layanan bahasa dan kebudayaan profesional di lingkungan Universitas Airlangga. Berada di bawah koordinasi pimpinan universitas, Pusbamulya berkomitmen mendukung penguatan akademik, internasionalisasi, serta pengembangan kompetensi sumber daya manusia.

Layanan unggulan Pusbamulya mencakup tiga bidang utama:

1. *Pengujian Bahasa:* Penyelenggaraan tes kemahiran bahasa terstandar, seperti English Language Proficiency Test (ELPT UNAIR), TOEFL ITP, NAT-TEST (Bahasa Jepang), dan uji kompetensi bahasa lainnya secara luring maupun daring.
2. *Pelatihan dan Kursus Bahasa:* Program pelatihan bahasa Inggris (ELPT/IELTS preparation, general conversation, English for specific purposes) serta kelas bahasa asing seperti Jepang, Prancis, Belanda, dan BIPA.
3. *Penerjemahan dan Penjurubahasaan:* Jasa penerjemahan dokumen resmi/akademik, proofreading, serta layanan interpreter profesional.

Didukung oleh staf pengajar berpengalaman, kurikulum berkualitas, dan fasilitas modern, Pusbamulya tidak hanya melayani civitas akademika UNAIR, melainkan juga terbuka bagi masyarakat umum, instansi pemerintah, serta mitra korporat.',
            'tags'      => ['Internal UNAIR', 'UNAIR', 'Transaksi Booth'],
            'logo'      => 'https://1drv.ms/i/c/d980f1cf28fccf2b/IQA7mB1lMLQjRaB9Z2HsWQWFASJWfNf7SPIL0g6QtXlb2ig?e=hYNyEj',
            'contact'   => 'iyunwitari@staf.unair.ac.id',
            'whatsapp'  => '+62 812-1691-5819',
            'web'       => 'https://pusatbahasa.unair.ac.id/',
            'instagram' => '@pusatbahasaunair',
            'facebook'  => 'https://www.facebook.com/pusbaunair',
            'twitter'   => 'https://x.com/pusbamulya',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'd1',
            'booth_no'  => 22,
            'code'      => 'D1',
            'cluster'   => 2,
            'area'      => 'D',
            'name'      => 'Airlangga Bilirubin Sun',
            'instansi'  => '**Medika Karya Airlangga** merupakan **startup berbasis teknologi kesehatan yang telah berbadan hukum** dan menjadi salah satu bentuk implementasi **Indikator Kinerja Utama (IKU) 2**, melalui pengembangan *startup* berbasis teknologi yang melibatkan dosen, alumni, dan mahasiswa Universitas Airlangga (UNAIR).  **Visi:** Menjadi perusahaan di era Revolusi Industri 4.0 yang unggul sebagai penyedia teknologi dan peralatan kesehatan berbasis **riset berkelanjutan dan inovasi**, serta mampu memberikan dampak nyata bagi peningkatan kualitas pelayanan kesehatan.  **Misi:** Mengembangkan, menghasilkan, dan menyediakan produk teknologi kesehatan berkualitas tinggi yang memenuhi standar nasional dan internasional. **PT Medika Karya Airlangga** membuka ruang kolaborasi bagi sumber daya manusia yang kompeten untuk menghasilkan inovasi dan karya dalam negeri yang berkualitas, berdaya saing, serta memiliki nilai hilirisasi dan komersialisasi. Perusahaan berkomitmen memperkuat kemandirian teknologi kesehatan Indonesia serta memperluas daya saing produk inovasi nasional di pasar domestik maupun internasional.',
            'pic'       => 'Hasbi Assidiq',
            'cat'       => 'Kesehatan & Farmasi',
            'desc'      => 'AirBiliSun adalah inovasi fototerapi cahaya matahari terfilter yang aman untuk bayi kuning, mencegah paparan sinar UV, serta mendukung pemerataan akses fototerapi, terutama di wilayah 3T Indonesia.',
            'tags'      => ['Kesehatan & Farmasi', 'Startup', 'Transaksi Booth'],
            'logo'      => 'https://drive.google.com/drive/folders/1lOSN52HaGbJoTn-2QE-clYMYfWctUN9K?usp=sharing',
            'contact'   => 'hasbi.assidiq1990@gmail.com',
            'whatsapp'  => '+62 851-1755-2990',
            'web'       => 'https://airbilisun.com',
            'instagram' => 'airbilisun',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'd2',
            'booth_no'  => 23,
            'code'      => 'D2',
            'cluster'   => 2,
            'area'      => 'D',
            'name'      => 'CESGS Universitas Airlangga',
            'instansi'  => 'CESGS Universitas Airlangga',
            'pic'       => 'Nisa Andini Faradina',
            'cat'       => 'Internal UNAIR',
            'desc'      => 'Center for Environmental, Social, and Governance Studies (CESGS) adalah pusat penelitian di bawah naungan Universitas Airlangga yang berfokus pada penanganan isu-isu keberlanjutan.',
            'tags'      => ['Internal UNAIR', 'Startup', 'Transaksi Booth'],
            'logo'      => 'https://canva.link/4oq79g3dse25ynz',
            'contact'   => 'esgi.dataset@gmail.com',
            'whatsapp'  => '085171700942',
            'web'       => 'https://cesgs.unair.ac.id/',
            'instagram' => 'cesgs.unair',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'd3',
            'booth_no'  => 24,
            'code'      => 'D3',
            'cluster'   => 2,
            'area'      => 'D',
            'name'      => 'Unit Layanan Pengujian (ULP)',
            'instansi'  => 'Unit Layanan Pengujian Fakultas Farmasi Unair (ULPFFUA)',
            'pic'       => 'Rizka Elvira Puteri',
            'cat'       => 'Internal UNAIR',
            'desc'      => 'Unit Layanan Pengujian Fakultas Farmasi Universitas Airlangga adalah Laboratorium pengujian kimia dan mikrobilogis produk obat, makanan dan kosmetik. ULP-FFUA merupakan salah satu unit pendukung Fakultas Farmasi Universitas Airlangga yang didirikan dan dikembangkan untuk memberikan pelayanan pengujian untuk keperluan pendidikan, penelitian dan pengabdian masyarakat.

Untuk Menjamin Kualitas Layanan pengujiannya ULP-FFUA pada tahun 2005 mulai mengajukan sertifikasi ISO 17025 dengan no LD-325-IDN. Untuk meningkatkan performa Unit Layanan Pengujian lebih lanjut, maka dilakukan penataan manajemen dan restruksi organisasi berdasarkan SK Dekan Fakultas Farmasi Unair no.2284/JO3.1.20/PP/2008 tertanggal 31 Oktober 2008.',
            'tags'      => ['Internal UNAIR', 'Startup', 'Transaksi Booth'],
            'logo'      => 'https://drive.google.com/drive/home',
            'contact'   => 'ulpffunair@gmail.com',
            'whatsapp'  => '082234079377',
            'web'       => 'https://ff.unair.ac.id/pgs/418/contact',
            'instagram' => 'ulp_unair',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'd4',
            'booth_no'  => 25,
            'code'      => 'D4',
            'cluster'   => 2,
            'area'      => 'D',
            'name'      => 'PUI-PT Bisnis Berkelanjutan (Center of Excellence for Sustainable Business)',
            'instansi'  => 'PUI-PT Center of Excellence for Sustainable Business',
            'pic'       => '',
            'cat'       => 'Riset & Pengembangan',
            'desc'      => 'Pusat Unggulan Ipteks Perguruan Tinggi Bisnis Berkelanjutan Universitas Airlangga.',
            'tags'      => ['Riset & Pengembangan', 'Startup'],
            'logo'      => '',
            'contact'   => '',
            'whatsapp'  => '',
            'web'       => '',
            'instagram' => '',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => '',
        ],
        [
            'id'        => 'd5',
            'booth_no'  => 26,
            'code'      => 'D5',
            'cluster'   => 2,
            'area'      => 'D',
            'name'      => 'Onggu Honey',
            'instansi'  => '**CV. RUMAH MATAHARI PAGI – ONGGU HONEY** **100% MADU HUTAN INDONESIA** *Murni • Alami • Teruji*  🍯 **FTIR Verified** Teruji keaslian melalui metode **FTIR (Fourier Transform Infrared Spectroscopy)**.  🌿 **Nektar Alam Hutan Indonesia** Berasal dari nektar alami berbagai tumbuhan hutan Indonesia yang menghasilkan karakter rasa, aroma, dan warna khas.  🔬 **Tersertifikasi Keamanan Pangan** Memenuhi standar keamanan pangan melalui **NKV, HACCP, dan Halal**.  🐝 **Konservasi Lebah** Mendukung pemanenan madu secara lestari melalui edukasi dan **eduwisata lebah madu**.  👒 **Pemberdayaan Petani Lebah Madu Lokal** Mendukung **peternak lebah madu serta pemburu/pemanen madu hutan liar Indonesia** melalui kemitraan dan pengembangan rantai pasok madu lokal.',
            'pic'       => 'Arrissa Fauziarachman',
            'cat'       => 'PGN',
            'desc'      => 'Onggu Honey dari CV. Rumah Matahari Pagi menghadirkan 100% madu hutan Indonesia dari nektar, murni, alami, dan teruji keaslian melalui metode FTIR. Berkomitmen pada keamanan pangan, konservasi lebah, edukasi, eduwisata, serta pemberdayaan peternak lebah madu dan pemanen madu hutan liar.',
            'tags'      => ['PGN', 'Startup', 'Transaksi Booth'],
            'logo'      => 'https://drive.google.com/drive/folders/1KS_vyi0EcVlD8kIjzcmNrgKaQ3tDRPST?usp=sharing',
            'contact'   => 'rumahmataharipagi@gmail.com',
            'whatsapp'  => '+62 813-5772-9664',
            'web'       => 'https://sites.google.com/view/onggu-honey/beranda',
            'instagram' => 'https://www.instagram.com/maduonggu/ https://www.instagram.com/ongguhoney/',
            'facebook'  => 'https://www.facebook.com/madu.onggu.1/',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'd6',
            'booth_no'  => 27,
            'code'      => 'D6',
            'cluster'   => 2,
            'area'      => 'D',
            'name'      => 'Espresso by Kopi Setengah Serious',
            'instansi'  => 'Espresso by Kopi Setengah Serious',
            'pic'       => 'Eka',
            'cat'       => 'Food & Beverage',
            'desc'      => 'Kopi Setengah Serious adalah produsen espresso literan dari Surabaya, yang menjadi solusi simpel dan mudah untuk membuat kopi enak ala kafe tanpa harus investasi alat. 
‎
‎Praktis tinggal tuang dan campur dengan air atau susu, produk kami telah terjual ribuan liter di e-commerce dan digunakan oleh pemilik kafe, umkm, kedai makanan maupun kopi keliling yang sedang merintis usaha dan ingin membuat menu kopi susu yang cepat namun tetap nikmat karena 1 Liter Espresso bisa untuk membuat 25-30 gelas kopi kekinian.
‎ 
‎Kami berbagi ide resep dan konsultasi resep kopi kekinian di Instagram & Tiktok @kopisetengahserious.',
            'tags'      => ['Food & Beverage', 'Startup', 'Transaksi Booth'],
            'logo'      => 'https://lh3.googleusercontent.com/d/1q3jIdITlmHoewLjiz-JwpHQ_fwkmWfK-',
            'contact'   => 'kopisetengahserious@gmail.com',
            'whatsapp'  => '087722617299',
            'web'       => 'https://linktr.ee/kopisetengahserious',
            'instagram' => 'instagram.com/kopisetengahserious',
            'facebook'  => 'facebook.com/kopisetengahserious',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'd7',
            'booth_no'  => 28,
            'code'      => 'D7',
            'cluster'   => 2,
            'area'      => 'D',
            'name'      => 'Sahabat Spondan',
            'instansi'  => 'Sahabat Spondan',
            'pic'       => 'AMRETA LARAS PERTIWI',
            'cat'       => 'PGN',
            'desc'      => 'Produk olahan siap saji yang menemani setiap kegiatanmu menjadi lebih berwarna. Menghadirkan cita rasa otentik dengan harga terjangkau yang dikemas dan disajikan dengan rasa cinta. Setiap gigitan menciptakan kehangatan dalam setiap kegiatan bersama teman, keluarga dan orang tersayang kamu.',
            'tags'      => ['PGN', 'Startup', 'Transaksi Booth'],
            'logo'      => 'https://lh3.googleusercontent.com/d/1rDtbjiMk_sq7NGKTtggGBJJVAEQREE3M',
            'contact'   => 'amretapertiwi3@gmail.com',
            'whatsapp'  => '085730171516',
            'web'       => '',
            'instagram' => 'https://www.instagram.com/sahabatspondan_sby?igsh=MTU1bzBzZXl1cHEzcQ==',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'd8',
            'booth_no'  => 29,
            'code'      => 'D8',
            'cluster'   => 2,
            'area'      => 'D',
            'name'      => 'MULIA SAMUDRA MAJU ABADI',
            'instansi'  => 'Mulia samudra maju abadi',
            'pic'       => 'Muhammad Syarif Satriyo samudra',
            'cat'       => 'Agrikultur & Akuakultur',
            'desc'      => 'CV. Mulia Samudra Maju Abadi (MSMA) merupakan usaha yang bergerak di bidang perikanan dan akuakultur berkelanjutan, dengan fokus pada budidaya dan pengembangan komoditas ikan serta rumput laut Gracilaria. MSMA mengintegrasikan kegiatan pembenihan, budidaya, pengumpulan hasil, pengolahan, hingga pemasaran untuk menghasilkan produk perikanan berkualitas dan bernilai ekonomi.
MSMA juga mengembangkan inovasi teknologi akuakultur, seperti IoT, pakan otomatis, monitoring kualitas air, serta konsep budidaya yang efisien dan ramah lingkungan, dengan tujuan membangun ekosistem perikanan modern, produktif, dan berkelanjutan.',
            'tags'      => ['Agrikultur & Akuakultur', 'Startup', 'Transaksi Booth'],
            'logo'      => 'https://www.instagram.com/muliasamudra?stkn=MWV3eTFneGxhdHk1Zw==',
            'contact'   => 'msatriyo@magister.ciputra.ac.id',
            'whatsapp'  => '081259545859',
            'web'       => 'https://Muliasamudra.com',
            'instagram' => 'Muliasamudra',
            'facebook'  => 'Mulia Samudra',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'd9',
            'booth_no'  => 30,
            'code'      => 'D9',
            'cluster'   => 2,
            'area'      => 'D',
            'name'      => 'Flordequeen Scalp and Hair Botanicals',
            'instansi'  => 'Universitas Ciputra Surabaya - UC Ventures',
            'pic'       => 'Selma Lady Diana',
            'cat'       => 'Eksternal UNAIR',
            'desc'      => 'Mengusung konsep eco-hair wellness, Flordequeen hadir sebagai merek perawatan rambut dan kulit kepala berbasis botani yang memadukan bahan-bahan alami pilihan dengan standar kualitas premium. Kami berkomitmen untuk menghadirkan solusi perawatan menyeluruh yang aman, efektif, serta berkelanjutan untuk kesehatan rambut dari akarnya.',
            'tags'      => ['Eksternal UNAIR', 'Startup', 'Transaksi Booth'],
            'logo'      => 'https://drive.google.com/drive/folders/1ztz7m1Shj3jzHC6b_2vOlUOS_2I0pULl?usp=sharing',
            'contact'   => 'flordequeen@gmail.com',
            'whatsapp'  => '0817290298',
            'web'       => 'https://flordequeen.com',
            'instagram' => '@flordequeen.co',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'd10',
            'booth_no'  => 31,
            'code'      => 'D10',
            'cluster'   => 2,
            'area'      => 'D',
            'name'      => 'INBIS PPNS',
            'instansi'  => 'Politeknik Perkapalan Negeri Surabaya',
            'pic'       => 'Yesica N Devi',
            'cat'       => 'Eksternal UNAIR',
            'desc'      => 'Inkubator bisnis Politeknik Perkapalan Negeri Surabaya merupakan unit yang memberikan pelayanan bantuan pendampingan bagi calon start up mulai dari inisiasi bisnis hingga scale up produk hasil riset dosen dan mahasiswa.',
            'tags'      => ['Eksternal UNAIR', 'Startup', 'Transaksi Booth'],
            'logo'      => 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBwgHBgkIBwgKCgkLDRYPDQwMDRsUFRAWIB0iIiAdHx8kKDQsJCYxJx8fLT0tMTU3Ojo6Iys/RD84QzQ5OjcBCgoKDQwNGg8PGjclHyU3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3N//AABEIAJQArQMBEQACEQEDEQH/xAAbAAEAAgMBAQAAAAAAAAAAAAAAAwYBBAcFAv/EADwQAAICAQIDBAULAgYDAAAAAAECAAMEBRESITEGQVFhBxMicYEUMjVCUnSRobLB0SPwM2JyseHxFSZT/8QAGwEBAAIDAQEAAAAAAAAAAAAAAAQFAQIDBgf/xAAwEQEAAgECBAQFBAIDAQAAAAAAAQIDBBEFEiExMkFhcRMigaHRI1GRweHxNLHwM//aAAwDAQACEQMRAD8A7jAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEDDHYbwPCyu1mk0WtTXf8psXqMccYHvPT85nLHwac+SeWPX8d2MU/GvyYo5p9Pz2Rp2uwz86jIXzIX+ZXTxLDvtESsI4dl23mYelhaxhZpC0Xrx/YbkT8DJGLVYsvhlHyabLj8UN8GSHBmAgICAgICAgICAgICAgICB82OlaM7sFVQSxJ2AEbbm+zkHaftXldo9QOm4FzU6cXKAryNo72Pl4D8ZaclNHgnPfrMRv+IU85b63UV0+OdomdvzLYx6K8aoVUrwqv5zwmo1GTUZJyZJ3mXvNPp8emxxixxtEJJx7u76RWZ1VPnb8tu6bViZmIr3a2mIrvPZbOz+tWNacTMYFQQldzdSe4GXGk1U83w79u0SqNXpYiPiUjv5LMOks1azAQEBAQEBAQEBAQEBAQECl+lLVXwNAGLS3DZmPwEg9EHNv2HxkzQ4+bLvPkgcQyzTFtHm5Zotnq9Tx2PTi4R7zy/eTOJ4rZdHkpXvt/wBK/hOauHW4727b7fzGy9jDu7wq+8zwMaa8voc6ikPsYL/XdNvLebxpbectJ1NfKEtdQQ+qxl47m7/DzPhOm1cfy06y0mbX+a/ZNfQtPyTDQ7u1gsdvHb+/ymLU5eXHHfcrfmi157bLjpGX8rwK7G+eCUf/AFA7GXWDL8THFlPnx/DyTDdnZxICAgICAgICAgICAgICByr0xWE6lp1W/srSzbeZIltw6PltKm4pPWsKCndLFUwvGg6tkaoi4wIGSq7HfYcYHfPH8W0ObBk5sXgn7e723COIYc+Ply+OPv7LDTpRI4sq5n/yqdhKqNPM+O262nPEeCNn3bmYuChroVSx6Ivj5mZtlx4o5aMVxXyzvZ8Ylb1mzUMzfjI9kHuH98prjrNd8t2ckxb9Kj2exjs+nXFv/udvwBk3hs747e6FxGIjJHssMsleQEBAQEBAQEBAQEBAQEDkvpf+m8L7uf1GW/DvBPupeKeOqjLLBUtiix6rEsrdkdTurA7EGYtWLRy26xLatrUnmrO0rPjdqMi9K6c9+FRyNtY6+bAftPOa/gt79dNb6T+XpeHcdpT5dTH1j+4/C1aUmnmsW4tyXnvfi32+HdKadFbTz89Z39V7GurqY+S0THo1NTz/AJSxqr/wlPM/aMg6jNz/AC17J+HDydbd1t7LYxx9HqLD2rSXPx6fltLjQ45phjfz6qfXXi+advLo9iTEQgICAgICAgICAgICAgIHJfS/9N4X3c/qMt+HeCfdS8U8dVGWWCqTJDCZYE1ZKndSQ3cQdjMWrFo2mNyJtWd4nafR6WFqVlLob1N9YPNHbbf4/wDcqdRwTR5p3ivLPp2/jsuNNx3WYI2meaPXv/Lpmh9rdM1IJTxfJrtthVbyB8gek45dFkxR0jePRLw6/Fm6TO0+qxAjpIqazAQEBAQEBAQEBAQEBAQOS+l/6bwvu5/UZb8O8E+6l4p46qMssFUmSGEywJUgTLDCZefXnAtHZ3tVlaaUpySb8MHb2ju6e49/ukPUaOmT5q9JT9Lr74tq261+8Oj4mVTmUJfjWLZU43Vl75TWratpraOsPQUvW9YtWd4lPNWxAQEBAQEBAQEBAQEDkvpf+m8L7uf1GW/DvBPupeKeOqjLLBVJkhhMsCVIEywwmSBKkMLJ2R1ttMzVouc/JLjwsD0Rj0b+ZE1en+LTmjvCfodV8G/Lafll0xZRvRswEBAQEBAQEBAQEBA5L6X/AKbwvu5/UZb8O8E+6l4p46qMssFUmSGEyAswVQSxOwAG5J8oO6+aT6O8m+kW6llfJiRyprXiYe877fDnK7LxGsTtSN/stMXC7WjfJO3oj1rsLladQ+Th5HyutBu1ZTZwPHrzm2LX0vO1o2aZ+G3x15qTurCeXST1bCVYEq9IY23dW7LZpztDxrXO9ijgf3jlKDVY/h5Zh6jRZfi4K2nu9aR0ogICAgICAgICAgIHJfS/9OYX3c/qMt+HeCfdS8U8dVGWWCqTJDC1ejrHqyO09HrQD6pHsUH7QGw/33kTXWmuGdv3TeH0i2ojf9nY5RvRvl+nKJHHe0OPXi6/n0UjatbSQPDcA7fnPQ6a02xVmXldVSKZ71jtv/lpLOyOlWB0D0euTpuUncMjcfFV/iVHEY/UifRecJn9O0ev9QtgletiAgICAgICAgICAgco9MNZGrafZt7LUso+B/5ltw6fltCm4rHzVlQ1liqUyQw9PQ9Ts0jU6c6pQxqPtKTtxqeRE55sUZaTSXXDlnDki8O06TrOFq9C24N6PuOaHky+REoMmK+OdrQ9Liz48sb0lBrvaDC0ehnvtVrgNkpVt2Y/sPObYdPfNbaOzTUarHgrvM9XJr8izLybcm7/ABLXLt7yd5f1rFKxWPJ5m9pvabW7yLNmiZIZX70eIf8Ax2W/ccjYfBR/MqOIz88R6LvhEfp2n1/qFtletiAgICAgICAgICAgUb0saa2VodWbUpL4du77D6jcifgdvzk7QZOXJNZ81fxHFzYuaPJyVZcqBMkMJl+MDoGi+jv12Ot2r5FlTuNxTSo3X3kg/htKzLxCYttjhbYuFRaN8s/SGv2i7EtpOK+Xp9r30JzsR1HGo8eWwI+E6afXfEnkt0ctTw6cVeenWPurC8zvJ6tSrDCVenOB1Pslh/ItDx0YbPZvY247z/xtKHV5OfLPp0em0OL4eCI/fr/L2ZGTCAgICAgICAgICAgQ5OPXk0WUXoHqsUq6nvBmYmYneGtqxaNpcL7T6Bkdn9SbHtBahyWx7T9ZfD3jvl/p88Zqb+bzeq084b7eXk8xJ3RXsdl60t7RaajqGU5CnY+XP+Jy1E7YrezvpYi2asT+7us869SjyEWyl0dQyspBB7xtMxO07sTG8dXDUnpnj0qwLD2T0R9VzQ9ikYlJBsJ+sfsj++ki6vPGKm0d5TNFpZz3iZ8Mf+2dPUbCUT0rMBAQEBAQEBAQEBAQEDz9Y0jD1jCbEz6vWVt0P1kPiD3Gb48lsduasueXFXJXltDlev8AYfUtJZrMVWzMQcw6Dd1Hmv7iXGHW0ydLdJUWfh+THO9OsNDsmf8A2XTfEZA68vGdtT/8bezhpP8AkVh3OeeeofNnzD7oYns4WnUAcyTsB4menePWrQeyGbnOlucrYuN1IYbWN7h3e8/hIWfW0p0r1n7LDTcPyZPmv0j7ui4WHRg46Y+LWK6kGwUf7nxMp73te3NbuvseOuOsVrG0J5q3ICAgICAgICAgICAgICBjaBqXaZgXZNeTbiUtfW3EtnAOIH3zeMlojaJ6NJxUmeaY6tyaN2GG4gaeDpWn6fv8jxKaT9pVG/4zpfLe/indyx4cePwViG5ynN1ZgICAgICAgICAgICBg9IHhZGs20W08VCvQcm2u5lPOtE+v57ct/Lc92xCLH126/J03GRa+PNx1u4+fCBzLc+hOw5DqeZ6KYG+mfa1dDFV/qZj0H/SC4B9/siBp6Xrj2evfOHBVXS13EamTkpIIG/zgBsdx4wMJrN+RoGVmUtjDKxgxdUPrE6cQG4P2SOfjvA3HvzLM9sGiypXpoS2216yQ3EzAALvy+Yd+feIHnZuvZFdGO1YqWx6rf6ZVm9bajhAikdzEnYnygetquW+JgNfWBx7qACN9tyB0HXrOGoyTjpNo7u+mxRlyxWe3+Gpi6pba2CjIga622u3r7PCCRyPQ8hyPjONdRaZpEx3mY/iJl1yaatYvMT2iJj67PjE1XJd7lvStHFT2LXwsDy8D0Ybd4mMeovM2i3TpM+f+p+jfJpaRFZpO8bxG/Tz+8IadevsxspzUi2Y+Eb2Xwfny922x+M501t7VtMx1iu/16/4dL6GlbVjfpNtvp/vds5ep5FGZWvDWtBCEuysQSx5jcfN28xznXJnvW8dOnT9/P27fVxxabHakzv169Onl79/6e1vJqEzAQEBAQEBAQPl/mmBAMLHD8YqHEGZgd+9vnfjAhXTMJEqrTGRUpRVrC7jgCndQPDaB9JpuKmWcpa29buTzsYqCepC78IPntvAiq0jBq9YFpYixdiHtdhtvvsNydhv3DlA2LcLGsN6vUCL0CW93EOcD5zMDGzSjXq/Gu4D12NW2x6jdSDt5dOUDFmnYbVJUcdPVrX6lVHIKnI7DbpzUfhAlyKKsmlqr04kPUb7TS1K3jazauS2OeavdBXg4tXqvV0qPVMzJzJ2LAgnz33mkYcdYjaOzec+S023nv8A0xTpuHS7tXQoLKV6nkD1A8PhMVwY69oZtqctojezLadicL/0F9ukUt19pB0EzOHH+3eNvoxGoyzt83ad/qxdp+JbYLrKFZxt3nY7dNx37ecxODHaYmY/ZmNRlrE1ien5b4ndxZgICAgf/9k=',
            'contact'   => 'yesica@ppns.ac.id',
            'whatsapp'  => '082332357444',
            'web'       => '',
            'instagram' => 'https://www.instagram.com/inovasippns/?hl=en',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'd11',
            'booth_no'  => 32,
            'code'      => 'D11',
            'cluster'   => 2,
            'area'      => 'D',
            'name'      => 'UIN Maulana Malik Ibrahim Malang',
            'instansi'  => 'UIN Maliki Malang melalui Phytonomics Research Group mengembangkan inovasi bahan alam menjadi produk kesehatan dan kosmetik, seperti Hermarin, Osteprim, Malstonin, Rahza, Uvamax, dan Rootēra, melalui riset dan hilirisasi.',
            'pic'       => 'apt. Novia Maulina, M. Farm.',
            'cat'       => 'Eksternal UNAIR',
            'desc'      => 'UIN Maliki Malang melalui Phytonomics Research Group mengembangkan inovasi bahan alam menjadi produk kesehatan dan kosmetik, seperti Hermarin, Osteprim, Malstonin, Rahza, Uvamax, dan Rootēra, melalui riset dan hilirisasi.',
            'tags'      => ['Eksternal UNAIR', 'Startup', 'Transaksi Booth'],
            'logo'      => 'https://lh3.googleusercontent.com/d/1YUFXnGMMV7ZJ1yviqhdkhAIGEET5E_e_',
            'contact'   => 'noviamaulina@gmail.com',
            'whatsapp'  => '081296050993',
            'web'       => 'https://fkik.uin-malang.ac.id/',
            'instagram' => 'https://www.instagram.com/hermarin.official?stkn=bnFxYnk5dXQxdXhj',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'c1',
            'booth_no'  => 38,
            'code'      => 'C1',
            'cluster'   => 2,
            'area'      => 'C',
            'name'      => 'Balai Besar POM di Surabaya',
            'instansi'  => 'Balai Besar POM di Surabaya, Awake Dewe Siap Ngeladeni Rek',
            'pic'       => 'Irma Rahmawati',
            'cat'       => 'Eksternal UNAIR',
            'desc'      => 'Layanan informasi dan konsultasi terkait registrasi dan sertifikasi Obat dan Makanan',
            'tags'      => ['Eksternal UNAIR', 'Transaksi Booth'],
            'logo'      => 'https://lh3.googleusercontent.com/d/1gcg6qa0U5n1UUA7ZMODw5548RTtwrKWO',
            'contact'   => 'sertifikasisby@gmail.com ; irma.rahmawati@pom.go.id',
            'whatsapp'  => '085645397002',
            'web'       => 'https://surabaya.pom.go.id/',
            'instagram' => 'bpom.surabaya',
            'facebook'  => 'Balai Besar POM di Surabaya',
            'twitter'   => '@BPOM_Surabaya',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'c4',
            'booth_no'  => 41,
            'code'      => 'C4',
            'cluster'   => 2,
            'area'      => 'C',
            'name'      => 'Jamkrindo',
            'instansi'  => 'PT Jaminan Kredit Indonesia (Jamkrindo)',
            'pic'       => '',
            'cat'       => 'Sponsorship / Mitra',
            'desc'      => 'Booth Sponsorship Jamkrindo di pameran inovasi ASSIE IV 2026.',
            'tags'      => ['Sponsorship / Mitra'],
            'logo'      => '',
            'contact'   => '',
            'whatsapp'  => '',
            'web'       => 'https://www.jamkrindo.co.id/',
            'instagram' => '',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => '',
        ],
        [
            'id'        => 'f1',
            'booth_no'  => 51,
            'code'      => 'F1',
            'cluster'   => 4,
            'area'      => 'F',
            'name'      => 'Bangga EVCS',
            'instansi'  => 'Bangga EVCS',
            'pic'       => 'Ibnu Andhika Hidayat',
            'cat'       => 'Manufaktur',
            'desc'      => 'Bangga EVCS merupakan sebuah inisiatif berbasis riset dari Universitas Airlangga yang berfokus pada pengembangan sistem charging kendaraan listrik (Electric Vehicle/EV). Inisiatif ini melibatkan kolaborasi antara mahasiswa dan dosen, sehingga mampu menggabungkan kekuatan inovasi, riset akademik, serta pengalaman praktis dalam menjawab kebutuhan infrastruktur pengisian daya di Indonesia yang terus berkembang.

Fokus utama Bangga EVCS terletak pada perancangan dan pengembangan teknologi charging yang adaptif, efisien, dan relevan dengan kondisi kelistrikan nasional. Sistem yang dikembangkan umumnya mengacu pada standar internasional, dengan kemampuan operasional pada konfigurasi 1 phase hingga 3 phase, serta rentang daya yang kompetitif untuk penggunaan residensial maupun komersial. Selain itu, Bangga EVCS juga mengintegrasikan konsep smart charging, yang memungkinkan pengguna untuk melakukan monitoring konsumsi daya, kontrol jarak jauh melalui aplikasi, serta pengaturan strategi pengisian untuk meningkatkan efisiensi energi dan menjaga keandalan sistem.

Dalam proses pengembangannya, Bangga EVCS menerapkan pendekatan end-to-end, mulai dari studi literatur, simulasi sistem kelistrikan, desain hardware, hingga integrasi software dan pengujian langsung. Kolaborasi antara mahasiswa dan dosen menjadi kunci dalam memastikan bahwa setiap solusi yang dihasilkan tidak hanya inovatif, tetapi juga memiliki dasar ilmiah yang kuat dan potensi implementasi nyata.

Lebih dari sekadar proyek riset, Bangga EVCS juga berperan sebagai wadah pengembangan kompetensi lintas bidang, baik teknis maupun non-teknis. Dengan semangat kolaborasi dan inovasi, Bangga EVCS berkomitmen untuk berkontribusi dalam percepatan pengembangan ekosistem kendaraan listrik di Indonesia, khususnya melalui solusi charging yang andal, cerdas, dan berkelanjutan.',
            'tags'      => ['Manufaktur', 'Startup', 'Transaksi Booth'],
            'logo'      => 'https://lh3.googleusercontent.com/d/17x65GV1NCa1R39T56wUMehjhpC66zyfX',
            'contact'   => 'ibnuandikahidayat02@gmail.com',
            'whatsapp'  => '+62 811-1020-416',
            'web'       => 'https://bangga-evcs.com/',
            'instagram' => 'https://www.instagram.com/bangga.evcs/?utm_source=ig_web_button_share_sheet',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'f2',
            'booth_no'  => 52,
            'code'      => 'F2',
            'cluster'   => 4,
            'area'      => 'F',
            'name'      => 'KINARA INDUSTRIES',
            'instansi'  => 'CV Kreasi Industri Nusantara',
            'pic'       => 'Rizki Indra Pratama',
            'cat'       => 'Manufaktur',
            'desc'      => 'KINARA INDUSTRIES adalah startup yang bergerak dibidang manufaktur Industri, mendukung berbagai jenis Research and Development Prototiping mesin dan alat kesehatan yang berbasis di Surabaya, Jawa Timur.',
            'tags'      => ['Manufaktur', 'Startup', 'Transaksi Booth'],
            'logo'      => 'https://drive.google.com/drive/folders/1isR-updkUueJ71BuqL2fhD01QZlrekLo?usp=sharing',
            'contact'   => 'kreasiindustrinusantara@gmail.com',
            'whatsapp'  => '085136887424',
            'web'       => 'https://www.kinaraindustries.com',
            'instagram' => '@kinara.industries',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'f3',
            'booth_no'  => 53,
            'code'      => 'F3',
            'cluster'   => 4,
            'area'      => 'F',
            'name'      => 'Olimnesia',
            'instansi'  => 'Startup BPRIn',
            'pic'       => 'Dimaz',
            'cat'       => 'Edutech',
            'desc'      => 'Olimnesia adalah platform edutech yang menghadirkan ekosistem kompetisi dan pembelajaran bagi pelajar. Olimnesia membantu sekolah, lembaga pendidikan, dan penyelenggara lomba dalam mengelola kompetisi secara digital, mulai dari pendaftaran, pelaksanaan ujian/CBT, hingga sertifikat dan publikasi hasil.
Bagi pelajar, Olimnesia menjadi ruang untuk mengikuti berbagai kompetisi, mengembangkan kemampuan, dan mendapatkan pengalaman belajar yang lebih seru dan bermakna.',
            'tags'      => ['Edutech', 'Startup', 'Transaksi Booth'],
            'logo'      => 'https://lh3.googleusercontent.com/d/1AbBaAE-8a68mH3oVc5ns1CtDW9UgpWUc',
            'contact'   => 'olimnesia@gmail.com',
            'whatsapp'  => '085102717040',
            'web'       => 'https://Olimnesia.com',
            'instagram' => 'Olimnesia',
            'facebook'  => 'Olimnesia',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'f4',
            'booth_no'  => 54,
            'code'      => 'F4',
            'cluster'   => 4,
            'area'      => 'F',
            'name'      => 'PT Jobhun Membangun Indonesia',
            'instansi'  => 'PT Jobhun Membangun Indonesia',
            'pic'       => 'Ayu Shinta Devi',
            'cat'       => 'Jasa',
            'desc'      => 'Tingkatkan Skill, Dapatkan Sertifikasi, Siap Bersaing di Dunia Kerja

Temukan skill terbaikmu melalui pelatihan bersama expert berpengalaman dan buktikan dengan uji kompetensi bersertifikat resmi di Jobhun.',
            'tags'      => ['Jasa', 'Startup', 'Transaksi Booth'],
            'logo'      => 'https://lh3.googleusercontent.com/d/1Vv1M8BXeVQnq2tj2y52TBUjkVRzS4jJh',
            'contact'   => 'info@jobhun.id',
            'whatsapp'  => '082336010250',
            'web'       => 'https://www.jobhun.id',
            'instagram' => 'jobhun',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'f5',
            'booth_no'  => 55,
            'code'      => 'F5',
            'cluster'   => 4,
            'area'      => 'F',
            'name'      => 'Serasa Djiwa',
            'instansi'  => 'Serasa Djiwa',
            'pic'       => 'Najway Azka Arrobbaniy',
            'cat'       => 'Jasa',
            'desc'      => 'Serasa Djiwa dapat diposisikan sebagai penyedia layanan psikologi yang humanis, kolaboratif, dan komprehensif, dengan cakupan layanan dari anak hingga dewasa serta individu hingga organisasi. Filosofi Compassion, Collaboration, Change menjadi dasar bahwa layanan tidak hanya berfokus pada penyelesaian masalah, tetapi juga pada proses memahami, mendampingi, dan mendorong perubahan yang bermakna.
Untuk kegiatan pameran layanan psikologi, Serasa Djiwa dapat hadir sebagai ruang yang interaktif dan edukatif, tempat pengunjung mengenal psikologi secara lebih dekat sekaligus memahami layanan yang sesuai dengan kebutuhannya. Booth dapat memperkenalkan beberapa area utama, seperti asesmen psikologi, konseling, konsultasi, coaching, mentoring, psikoedukasi, dan pelatihan, serta layanan khusus di bidang pendidikan, perkembangan anak, dan industri-organisasi. 
Konsep pameran tidak hanya bersifat promosi layanan, tetapi juga memberikan pengalaman psikologis yang ringan, relevan, dan aplikatif. Misalnya melalui mini psychological check-up, konsultasi singkat, permainan atau aktivitas reflektif, edukasi mengenai tumbuh kembang dan kesehatan mental, serta informasi mengenai pilihan layanan yang dapat diakses pengunjung. Pendekatan ini selaras dengan visi Serasa Djiwa untuk mendukung kesejahteraan, pengembangan diri, dan kualitas hidup melalui layanan yang berlandaskan kemanusiaan, empati, dan kolaborasi.
Dengan demikian, pameran Serasa Djiwa dapat menjadi ruang untuk “mengenal diri, memahami kebutuhan, dan menemukan langkah perubahan”, sekaligus memperkenalkan Serasa Djiwa sebagai partner psikologis yang hadir untuk berbagai tahap kehidupan.',
            'tags'      => ['Jasa', 'Startup', 'Transaksi Booth'],
            'logo'      => 'https://canva.link/8iln2gko7k79ndd',
            'contact'   => 'serasadjiwa21@gmail.com',
            'whatsapp'  => '+62 856-4514-5191',
            'web'       => '',
            'instagram' => '@serasadjiwa',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'f6',
            'booth_no'  => 56,
            'code'      => 'F6',
            'cluster'   => 4,
            'area'      => 'F',
            'name'      => 'Rexgo.Technology',
            'instansi'  => 'Rexgo.Technology',
            'pic'       => 'INDRA BAYU PURWANTORO',
            'cat'       => 'Edutech',
            'desc'      => 'REXGO adalah perusahaan teknologi interaktif yang menciptakan pengalaman digital untuk event, pameran, ritel, pendidikan, pariwisata, dan brand activation. Kami menggabungkan teknologi dan kreativitas untuk meningkatkan engagement audiens.',
            'tags'      => ['Edutech', 'Startup', 'Transaksi Booth'],
            'logo'      => 'https://drive.google.com/drive/folders/1dkQM6GzOmyNLTXxYQxCUBgnXCBXjIcNZ?usp=sharing',
            'contact'   => 'rexgotech@gmail.com',
            'whatsapp'  => '081217260020',
            'web'       => 'https://www.rexgotech.com',
            'instagram' => '@rexgo.tech',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'f7',
            'booth_no'  => 57,
            'code'      => 'F7',
            'cluster'   => 4,
            'area'      => 'F',
            'name'      => 'Azura Umroh Private',
            'instansi'  => 'Startup',
            'pic'       => 'Venti',
            'cat'       => 'Jasa',
            'desc'      => 'Azura menemani perjalanan ibadah umroh secara private dan prioritas dengan hotel dekat masjid, mobil pribadi dan muthawif pribadi.',
            'tags'      => ['Jasa', 'Startup', 'Transaksi Booth'],
            'logo'      => 'https://lh3.googleusercontent.com/d/1XmUIE1ZdFZmjd-BhLkRAgNIDczYXVTuZ',
            'contact'   => 'vechoirunnisa10@gmail.com',
            'whatsapp'  => '085161377131',
            'web'       => '',
            'instagram' => 'https://www.instagram.com/azura.umrohprivate?igsh=MTBoMHVpZGZhcXRhYg==',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'f8',
            'booth_no'  => 58,
            'code'      => 'F8',
            'cluster'   => 4,
            'area'      => 'F',
            'name'      => 'Lokasi Nusantara Tour and Travel',
            'instansi'  => 'Startup',
            'pic'       => 'Aura Putricia Mahardini',
            'cat'       => 'Jasa',
            'desc'      => 'Lokasi Nusantara adalah pelopor jasa open & private trip berbasis penyembuhan jiwa dan keakraban komunitas. Menghadirkan wisata alam bernilai tinggi yang ramah waktu ibadah, fleksibel, serta mendukung keberdayaan UMKM lokal secara nyata.',
            'tags'      => ['Jasa', 'Startup', 'Transaksi Booth'],
            'logo'      => 'https://drive.google.com/drive/folders/129o7v3LjmCEYwPZK3p5Bm4FcjkKEhU_8',
            'contact'   => 'auramahardini@gmail.com',
            'whatsapp'  => '081230498086',
            'web'       => '',
            'instagram' => '@lokasi.nusantara',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'f9',
            'booth_no'  => 59,
            'code'      => 'F9',
            'cluster'   => 4,
            'area'      => 'F',
            'name'      => 'Japonindo Yotsuba',
            'instansi'  => 'Japonindo Yotsuba',
            'pic'       => 'Arif Fatchur Rochmaniyah',
            'cat'       => 'Edutech',
            'desc'      => 'Kursus Bahasa Jepang untuk membantu peserta menguasai Bahasa Jepang secara praktris, komunikatif, dan menyenangkan sesuai dengan moto kami itsudemo, dokodemo manabou!',
            'tags'      => ['Edutech', 'Startup', 'Transaksi Booth'],
            'logo'      => 'https://drive.google.com/drive/folders/1yZMU_fzmo1Dl19g2l4AC0nR4UJ6IXMNc?usp=sharing',
            'contact'   => 'arifrahmania11@gmail.com',
            'whatsapp'  => '08563185856',
            'web'       => '',
            'instagram' => 'japonindo.yotsuba',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'f10',
            'booth_no'  => 60,
            'code'      => 'F10',
            'cluster'   => 4,
            'area'      => 'F',
            'name'      => 'Tempat Tumbuh',
            'instansi'  => 'Tempat Tumbuh Strategic Partner of PT Inspirasi Keuangan Syariah',
            'pic'       => 'Saif Ali Khan',
            'cat'       => 'Jasa',
            'desc'      => 'Tempat Tumbuh merupakan platform pembelajaran keuangan yang membantu individu memahami konsep perencanaan dan pengelolaan keuangan, cara menyusun, beserta strategi implementasi dalam kehidupan sehari-hari secara lebih terarah dan terstruktur. Kami hadir bukan hanya sebagai platform edukasi, melainkan ekosistem pembelajaran yang berkomitmen membantu masyarakat Indonesia membangun perilaku finansial yang lebih sehat, disiplin, dan berkelanjutan. Berdiri sejak tahun 2025, Tempat Tumbuh telah menjalin
kolaborasi strategis dengan beberapa mitra, mulai dari lembaga pendidikan, pelatihan, konsultasi, dan sertifikasi keuangan, lembaga pemberdayaan karir, hingga komunitas pengembangan diri. Kehadiran mitra strategis ini memperkuat langkah kami dalam membangun ekosistem pembelajaran keuangan yang inklusif dan berkelanjutan bagi masyarakat Indonesia.',
            'tags'      => ['Jasa', 'Startup', 'Transaksi Booth'],
            'logo'      => 'https://drive.google.com/drive/folders/1Cl2zxekgqqqAgVPtMEHNJ7WbgR5g2E1e?usp=sharing',
            'contact'   => 'imondeskhan@gmail.com',
            'whatsapp'  => '089603446997',
            'web'       => 'https://ptiksh.com/',
            'instagram' => 'tempattumbuh_edu',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'f11',
            'booth_no'  => 61,
            'code'      => 'F11',
            'cluster'   => 4,
            'area'      => 'F',
            'name'      => 'FastrackEdu',
            'instansi'  => 'Fastrack Edu Tenant Binaan Atavi Unair',
            'pic'       => 'Khoirotul Amaliyah',
            'cat'       => 'Jasa',
            'desc'      => 'FastrackEdu hadir sebagai ekosistem pembelajaran digital terdepan yang dirancang khusus untuk membekali mahasiswa dengan keterampilan esensial dalam bidang riset dan penulisan ilmiah. Melalui integrasi pendekatan berbasis teknologi mutakhir serta bimbingan intensif dari para ahli, platform ini memastikan setiap mahasiswa mampu menghasilkan karya yang kredibel dan berkualitas.',
            'tags'      => ['Jasa', 'Startup', 'Transaksi Booth'],
            'logo'      => 'https://drive.google.com/drive/folders/1Iqz74JjGOXVJOo6igBzfXeOzmtldr5na?usp=sharing',
            'contact'   => 'abdulzidan118@gmail.com',
            'whatsapp'  => '085748828183',
            'web'       => 'https://fastrackedu.id/',
            'instagram' => 'https://www.instagram.com/fastrackedu.official/',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'f12',
            'booth_no'  => 62,
            'code'      => 'F12',
            'cluster'   => 4,
            'area'      => 'F',
            'name'      => 'Vitalic Hit Trigger Drum',
            'instansi'  => 'PASINBIS',
            'pic'       => 'FAISHAL AZKA CAHYO ANGGONO',
            'cat'       => 'Edutech',
            'desc'      => 'Vitalic Hit Trigger Drum adalah perangkat sensor elektronik buatan lokal Indonesia yang dipasang pada drum akustik untuk mengubah getaran pukulan menjadi sinyal suara digital atau elektrik',
            'tags'      => ['Edutech', 'Startup', 'Transaksi Booth'],
            'logo'      => 'https://drive.google.com/drive/folders/1tKFT7tniOli05h35K1u6Jrzvc7OV3Mgr',
            'contact'   => 'vitalichittrigger@gmail.com',
            'whatsapp'  => '081358502672',
            'web'       => 'https://www.vitalichittrigger.com',
            'instagram' => 'vitalic.hit_footrix',
            'facebook'  => 'Vitalic Hit Trigger',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'f13',
            'booth_no'  => 63,
            'code'      => 'F13',
            'cluster'   => 4,
            'area'      => 'F',
            'name'      => 'KONVETO',
            'instansi'  => 'Konveto (SERAGAMKANAKSIMU)',
            'pic'       => 'Ardian',
            'cat'       => 'Craft',
            'desc'      => 'Konveto startup yang bergerak di bidang jasa konveksi seragam',
            'tags'      => ['Craft', 'Startup', 'Transaksi Booth'],
            'logo'      => 'https://lh3.googleusercontent.com/d/181gclsNUE2RfS0OvSCMvEPiqHIb1dtQ2',
            'contact'   => 'konvetosurabaya@gmail.com',
            'whatsapp'  => '08993672913',
            'web'       => '',
            'instagram' => '@Konveto.id',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'f14',
            'booth_no'  => 64,
            'code'      => 'F14',
            'cluster'   => 4,
            'area'      => 'F',
            'name'      => 'HEZTEK CODING',
            'instansi'  => 'HEZTEK CODING adalah tenant startup yang dibina oleh inkubator bisnis ATAVI UNAIR sejak 2021',
            'pic'       => 'Heni Prasetyorini, S.Si., M.Pd',
            'cat'       => 'Edutech',
            'desc'      => 'Ayo bermain, belajar, dan bikin project seru dengan coding bersama teman, orang tua, dan guru di Heztek Coding.',
            'tags'      => ['Edutech', 'Startup', 'Transaksi Booth'],
            'logo'      => 'https://lh3.googleusercontent.com/d/1HzGCvfI_KO2NJVvMB6f915oeM_u1FwS8',
            'contact'   => 'heztekcoding@gmail.com',
            'whatsapp'  => '089699264015',
            'web'       => 'https://www.heztekcoding.com/',
            'instagram' => 'https://www.instagram.com/heztekcoding/',
            'facebook'  => 'https://www.facebook.com/heztekcoding/',
            'twitter'   => 'https://www.threads.com/@heztekcoding?hl=id',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'f15',
            'booth_no'  => 65,
            'code'      => 'F15',
            'cluster'   => 4,
            'area'      => 'F',
            'name'      => 'Braja Elektrik X Renergy',
            'instansi'  => 'Braja Elektrik X Renergy',
            'pic'       => 'Uta',
            'cat'       => 'Manufaktur',
            'desc'      => 'Startup ekosistem kendaraan listrik dan konversi',
            'tags'      => ['Manufaktur', 'Startup', 'Transaksi Booth'],
            'logo'      => 'https://lh3.googleusercontent.com/d/1BVJcINuVLr62_jwwOoBAe8HgGLAPtgnO',
            'contact'   => 'brajaelektrikmotor@gmail.com',
            'whatsapp'  => '082133881104',
            'web'       => 'https://www.brajaelektrikmotor.com',
            'instagram' => 'Braja Elektrik Motor',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'f16',
            'booth_no'  => 66,
            'code'      => 'F16',
            'cluster'   => 4,
            'area'      => 'F',
            'name'      => 'Sriwijaya Kontraktor',
            'instansi'  => 'PT SRIWIJAYA KONTRAKTOR',
            'pic'       => 'Bapak Firdaus',
            'cat'       => 'Manufaktur',
            'desc'      => 'Kami adalah perusahaan jasa konstruksi dan pembangunan yang melayani proyek rumah satu atau dua lantai. Kami juga menyediakan jasa desain 2D dan 3D untuk seluruh wilayah di Indonesia. Adapun pembangunan fisik mencakup area Jawa, Bali dan Jabodetabek',
            'tags'      => ['Manufaktur', 'Startup', 'Transaksi Booth'],
            'logo'      => 'https://sriwijayakontraktor.com/',
            'contact'   => 'al.firdaus.work@gmail.com',
            'whatsapp'  => '082228520581',
            'web'       => 'https://sriwijayakontraktor.com',
            'instagram' => 'sriwijaya kontraktor',
            'facebook'  => 'Sriwijaya Kontraktor',
            'twitter'   => 'Sriwijaya Kontraktor',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'f17',
            'booth_no'  => 67,
            'code'      => 'F17',
            'cluster'   => 4,
            'area'      => 'F',
            'name'      => 'APPA TECH',
            'instansi'  => 'APPA TECH',
            'pic'       => 'Razan Mahrani',
            'cat'       => 'Jasa',
            'desc'      => 'Perusahaan yang bergerak di bidang inovasi teknologi, khususnya kecerdasan buatan. Saat ini berfokus pada industri olahraga dan perkantoran',
            'tags'      => ['Jasa', 'Startup', 'Transaksi Booth'],
            'logo'      => 'https://lh3.googleusercontent.com/d/1Fx36qqmA9ChB2XRTQSjmkP4SNW1IcWNg',
            'contact'   => 'razanmahrani@gmail.com',
            'whatsapp'  => '085730394996',
            'web'       => 'https://grahateknologimaju.com/en',
            'instagram' => 'academyappa',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'f18',
            'booth_no'  => 68,
            'code'      => 'F18',
            'cluster'   => 4,
            'area'      => 'F',
            'name'      => 'Likur Production',
            'instansi'  => 'Airlangga Startup and Innovation Incubator (ATAVI)',
            'pic'       => 'Reyhan Agung Ramadhan',
            'cat'       => 'Jasa',
            'desc'      => 'LIKUR Production is a Creative & Documentary Production House based in Surabaya, founded in 2022. Inspired by the Javanese philosophy “Linggih Kursi”, a symbol of leadership and independence. Likur embodies the spirit of young creators stepping into their own seat of responsibility: leading, collaborating, and shaping the future through storytelling.

We aspire to become Nusantara’s storyteller, bringing cultural heritage, local values, health, and eco-conscious into the modern era through timeless creative content.',
            'tags'      => ['Jasa', 'Startup', 'Transaksi Booth'],
            'logo'      => 'https://drive.google.com/drive/folders/1E2FM9zaARJgsg77XiMo0yxmJUAstqyhO?usp=sharing',
            'contact'   => 'likurproduction@gmail.com',
            'whatsapp'  => '085161328874',
            'web'       => 'https://likur.id',
            'instagram' => '@likurproduction',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'g1',
            'booth_no'  => 73,
            'code'      => 'G1',
            'cluster'   => 5,
            'area'      => 'G',
            'name'      => 'Deorans',
            'instansi'  => 'Universitas Airlangga',
            'pic'       => 'Raihan Syah Rafi\'',
            'cat'       => 'Kuliner & Bisnis',
            'desc'      => 'Deorans adalah deodoran alami berbahan mineral yang efektif melawan bau badan tanpa menghambat keringat. Aman, praktis, dan ramah kulit, Deorans hadir sebagai pilihan sehat untuk aktivitas sehari-hari.',
            'tags'      => ['Kuliner & Bisnis', 'F&B', 'Transaksi Booth'],
            'logo'      => 'https://lh3.googleusercontent.com/d/1X-RqaCuamaFYAx3-i-Qs7cjw3r5scswT',
            'contact'   => 'deoransspray@gmail.com',
            'whatsapp'  => '082132529584',
            'web'       => 'https://heylink.me/deorans',
            'instagram' => '@deoransspray',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'g2',
            'booth_no'  => 74,
            'code'      => 'G2',
            'cluster'   => 5,
            'area'      => 'G',
            'name'      => 'Tawdeo',
            'instansi'  => 'Tawdeo',
            'pic'       => 'Dela R G',
            'cat'       => 'Kesehatan & Farmasi',
            'desc'      => 'Tawdeo — Natural Care, Better for You & Earth

Tawdeo hadir sebagai brand personal care yang mengembangkan produk berbahan alami dengan mengutamakan manfaat, kenyamanan, dan kepedulian terhadap lingkungan. Dari perawatan tubuh hingga produk sehari-hari, Tawdeo ingin menghadirkan pilihan yang lebih bijak dan baik untuk diri sendiri maupun bumi.',
            'tags'      => ['Kesehatan & Farmasi', 'F&B', 'Transaksi Booth'],
            'logo'      => 'https://canva.link/3hu3b3qr4623vm5',
            'contact'   => 'tawdeonatural@gmail.com',
            'whatsapp'  => '085179771295',
            'web'       => '',
            'instagram' => '',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'g3',
            'booth_no'  => 75,
            'code'      => 'G3',
            'cluster'   => 5,
            'area'      => 'G',
            'name'      => 'Partner SEHATin',
            'instansi'  => 'Partner SEHATin',
            'pic'       => 'Ira Nurwahyu Kusuma',
            'cat'       => 'Kesehatan & Farmasi',
            'desc'      => 'Partner SEHATin adalah platform kesehatan keluarga terpadu yang hadir untuk meningkatkan akses masyarakat terhadap informasi dan layanan kesehatan yang edukatif, interaktif, dan mudah dijangkau. Partner SEHATin mendampingi masyarakat dalam perjalanan kesehatan sejak masa remaja, persiapan pernikahan, kehamilan, hingga peran sebagai orang tua.

Melalui layanan edukasi kesehatan, Partner SEHATin menyediakan informasi terpercaya mengenai kesehatan reproduksi, persiapan pranikah termasuk pre-marital check-up, kehamilan, serta penerapan pola hidup sehat bagi keluarga. Partner SEHATin juga menghadirkan ruang diskusi dan konsultasi yang memungkinkan pengguna bertanya dan memperoleh pendampingan terkait berbagai permasalahan kesehatan secara komunikatif dan mudah dipahami.

Untuk memperluas akses, Partner SEHATin mengintegrasikan pengguna dengan berbagai layanan kesehatan dan produk pendukung melalui platform digital. Dengan pendekatan yang fleksibel, terjangkau, dan terintegrasi, Partner SEHATin berkomitmen menjadi mitra kesehatan keluarga yang mendampingi setiap tahap kehidupan, sekaligus mendorong masyarakat untuk lebih sadar, mandiri, dan proaktif dalam menjaga kesehatan.',
            'tags'      => ['Kesehatan & Farmasi', 'F&B', 'Transaksi Booth'],
            'logo'      => 'https://lh3.googleusercontent.com/d/1-8kHDV4WLzEsPqYAkaUteqEC26z0scxQ',
            'contact'   => 'ira.nurwahyu@gmail.com',
            'whatsapp'  => '081232938578',
            'web'       => '',
            'instagram' => '@partner.sehatin.id',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'g4',
            'booth_no'  => 76,
            'code'      => 'G4',
            'cluster'   => 5,
            'area'      => 'G',
            'name'      => 'Sweetfood',
            'instansi'  => 'Universitas Airlangga',
            'pic'       => 'Eka Nur Lita',
            'cat'       => 'Food & Beverage',
            'desc'      => 'Sweetfood merupakan bisnis yang bergerak dibidang FnB yang berdiri sejak tahun 2023. Kami hadir membawa solusi atas masalah anda terkait "Dream Cake" pada hari special customer. Kami menawarkan cake dengan beberapa varian rasa, ukuran, dan desain yang dapat di custome sesuai kebutuhan customer dengan deadline waktu yang singkat dan jaminan pengiriman tepat waktu.
Kami menggunakan bahan-bahan berkualitas dengan proses produksi homemade sehingga cake terjaga kualitas dan cita rasanya.
Sweetfood telah bekerjasama dengan beberapa brand dan mendapatkan kepercayaan dari para customer melalui ribuan review positif serta loyalitas pelanggan. 

Tagline sweetfood "Timely, Affordable, and Reliable to Make Your Dream Cake Come True"',
            'tags'      => ['Food & Beverage', 'F&B', 'Transaksi Booth'],
            'logo'      => 'https://lh3.googleusercontent.com/d/1G-ErHL54m9m7zXBz_eAvakg0nKrafGLP',
            'contact'   => 'ekanurlt25@gmail.com',
            'whatsapp'  => '082326116698',
            'web'       => '',
            'instagram' => 'https://www.instagram.com/sweetfood_id_?igsh=Y3YyZjd1cHIwcGdm',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'g5',
            'booth_no'  => 77,
            'code'      => 'G5',
            'cluster'   => 5,
            'area'      => 'G',
            'name'      => 'GOLDEN GATE DIMSUM',
            'instansi'  => 'Golden Gate Dimsum x Mengoba-tea',
            'pic'       => 'Adinda Vidya Lestari',
            'cat'       => 'Food & Beverage',
            'desc'      => 'Golden Gate Dimsum x Mengoba-tea merupakan Business yang bergerak di bidang FnB dengan niche yaitu healthy Food and Beverages yang bisa menjadi bahan baku maupun ready to eat. Kami menyajikan bentuk frozen dengan kemasan bulk maupun siap saji. Bahan yang kami gunakan premium dan bebas msg sehingga penyimpanan setelah dibuka hanya sampai 3 bulan untuk memastikan mutu produk. Dengan terus berinovasi kami berharap bisa menciptakan produk yang berdaya saing tinggi dengan pengembangan teknologi yang lebih modern',
            'tags'      => ['Food & Beverage', 'F&B', 'Transaksi Booth'],
            'logo'      => 'https://canva.link/rpy259ds74snjea',
            'contact'   => 'adindavidya01@gmail.com',
            'whatsapp'  => '082220809000',
            'web'       => '',
            'instagram' => '@goldengatedimsum',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'g6',
            'booth_no'  => 78,
            'code'      => 'G6',
            'cluster'   => 5,
            'area'      => 'G',
            'name'      => 'lammaqbanna',
            'instansi'  => 'The Homemade',
            'pic'       => 'gusti',
            'cat'       => 'Food & Beverage',
            'desc'      => 'LAMMAQBANNA adalah startup binaan unair, bergerak dibidang seasoning dan snack, berlegalitas nib, pirt, halal dan terdaftar merk. kami juga peduli tentang sustainability diantaranya mengurangi foodwaste, produkkaldu bubuk kami mengusung konsep less waste, beberapa dari hasil penjualan untuk mendanai program intern dari kami yaitu "RING" sharing for caring, dengan membagikan hasil masakan dari dapur kami dan memakai bumbu dari hasil produksi kami.',
            'tags'      => ['Food & Beverage', 'F&B', 'Transaksi Booth'],
            'logo'      => 'https://lh3.googleusercontent.com/d/19ed1lPHoGiObDLcIN-Sq61E0Jw7kh5qq',
            'contact'   => 'lovellyemma48@gmail.com',
            'whatsapp'  => '081331114215',
            'web'       => 'https://s.id/thehomemade899',
            'instagram' => 'Thehomemade899',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'g7',
            'booth_no'  => 79,
            'code'      => 'G7',
            'cluster'   => 5,
            'area'      => 'G',
            'name'      => 'Ayam ungkep teh nisa',
            'instansi'  => 'Inkubator unair',
            'pic'       => 'Nisa Nurrohmah',
            'cat'       => 'Food & Beverage',
            'desc'      => 'Memproduksi ayam dan bebek siap goreng lengkap dengan sambal dalam kemasan vakum pack',
            'tags'      => ['Food & Beverage', 'F&B', 'Transaksi Booth'],
            'logo'      => 'https://lh3.googleusercontent.com/d/1Kv7BVBc41ODo7_9UUMTFrxZ2e0MxqnM0',
            'contact'   => 'nisasby777@gmail.com',
            'whatsapp'  => '081522979766',
            'web'       => '',
            'instagram' => 'Ayam ungkep teh nisa',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'g8',
            'booth_no'  => 80,
            'code'      => 'G8',
            'cluster'   => 5,
            'area'      => 'G',
            'name'      => 'Sahabat Spondan',
            'instansi'  => 'Sahabat Spondan',
            'pic'       => 'AMRETA LARAS PERTIWI',
            'cat'       => 'PGN',
            'desc'      => 'Produk olahan siap saji yang menemani setiap kegiatanmu menjadi lebih berwarna. Menghadirkan cita rasa otentik dengan harga terjangkau yang dikemas dan disajikan dengan rasa cinta. Setiap gigitan menciptakan kehangatan dalam setiap kegiatan bersama teman, keluarga dan orang tersayang kamu.',
            'tags'      => ['PGN', 'F&B', 'Transaksi Booth'],
            'logo'      => 'https://lh3.googleusercontent.com/d/1rDtbjiMk_sq7NGKTtggGBJJVAEQREE3M',
            'contact'   => 'amretapertiwi3@gmail.com',
            'whatsapp'  => '085730171516',
            'web'       => '',
            'instagram' => 'https://www.instagram.com/sahabatspondan_sby?igsh=MTU1bzBzZXl1cHEzcQ==',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'h1',
            'booth_no'  => 81,
            'code'      => 'H1',
            'cluster'   => 6,
            'area'      => 'H',
            'name'      => 'Gyarus Indonesia',
            'instansi'  => 'CV Gyarus Indonesia Group',
            'pic'       => 'Firdayanti Zahro',
            'cat'       => 'Fashion',
            'desc'      => 'Gyarus adalah brand lokal asal Surabaya yang bergerak di bidang fashion muslim, khususnya menghadirkan mukenah dengan desain yang nyaman, elegan, dan relevan dengan kebutuhan perempuan modern serta bisa custom  design. 

Dalam perkembangannya, Gyarus tidak hanya melayani kebutuhan konsumen secara retail, tetapi juga telah dipercaya untuk berkolaborasi dengan berbagai instansi dalam penyediaan gift dan merchandise, menjadikan produk Gyarus sebagai pilihan untuk kebutuhan personal maupun corporate gifting.

Dengan mengutamakan kualitas produk, desain yang menarik dan available custom design, Gyarus terus mengembangkan diri sebagai brand fashion lokal yang mampu menghadirkan produk bernilai guna sekaligus berkesan.',
            'tags'      => ['Fashion', 'Kreatif', 'Transaksi Booth'],
            'logo'      => 'https://lh3.googleusercontent.com/d/13P7RNVeVLv5VuJ7cCk9HuhQOhVu82Q2Z',
            'contact'   => 'firdayantizahro27@gmail.com',
            'whatsapp'  => '0877-0451-9225',
            'web'       => '',
            'instagram' => 'https://www.instagram.com/gyarus.id?igsh=MTk1N3Q0c3ZocjM0dA%3D%3D&utm_source=qr',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'h2',
            'booth_no'  => 82,
            'code'      => 'H2',
            'cluster'   => 6,
            'area'      => 'H',
            'name'      => 'Leastra',
            'instansi'  => 'Leastra',
            'pic'       => 'Adelia Permatasari',
            'cat'       => 'Craft',
            'desc'      => 'Leastra merupakan brand yang menjual aksesoris seperti dompet,lanyard dan card holder menggunakan kulit sapi dengan perpaduan batik. visi kami ialah menyejahterahkan pengrajin lokal dan membudidayakan penggunaan kain batik pada kehidupan sehari-hari',
            'tags'      => ['Craft', 'Kreatif', 'Transaksi Booth'],
            'logo'      => 'https://drive.google.com/drive/folders/1ZpIXKPPc6x-zB42q3HccJeuGFtj53F18?usp=sharing',
            'contact'   => 'adeliassari@gmail.com',
            'whatsapp'  => '081334331982',
            'web'       => '',
            'instagram' => '@leastra.id',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'h3',
            'booth_no'  => 83,
            'code'      => 'H3',
            'cluster'   => 6,
            'area'      => 'H',
            'name'      => 'Tjakrawala Batik & Crafts',
            'instansi'  => 'Tjakrawala Batik & Crafts',
            'pic'       => 'Azza Nur Fadilah',
            'cat'       => 'Fashion',
            'desc'      => 'Tjakrawala Batik & Crafts adalah rumah batik yang berfokus pada batik tulis khas Madura dan aneka kerajinan anyaman dari daun agel. Kami memproduksi berbagai macam batik tulis dengan motif tradisional dan kontemporer, serta memanfaatkan perca kain batik dan daun agel untuk menciptakan produk fashion dan home decor yang unik dan berkelanjutan.',
            'tags'      => ['Fashion', 'Kreatif', 'Transaksi Booth'],
            'logo'      => 'https://lh3.googleusercontent.com/d/1zgr3Mof7v_fwd7RFdGc6vdLrd8obiHd9',
            'contact'   => 'azzafadilah14@gmail.com',
            'whatsapp'  => '087850720142',
            'web'       => 'https://www.tjakrawalabatik.com',
            'instagram' => 'https://www.instagram.com/tjakrawala_batik/',
            'facebook'  => 'https://web.facebook.com/people/Tjakrawala-Batik-Crafts/61564244136391/?_rdc=10&_rdr',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'h4',
            'booth_no'  => 84,
            'code'      => 'H4',
            'cluster'   => 6,
            'area'      => 'H',
            'name'      => 'Botega Indonesia',
            'instansi'  => 'Botega Indonesia is a wellness brand dedicated to creating sensory experiences through thoughtfully crafted aromatic products. We transform beautiful scents into a variety of forms, including aromatherapy candles, soaps, perfumes, massage oils, and reed diffusers. Each product is designed to bring comfort, relaxation, and a meaningful moment of self-care into everyday life.  More than just a fragrance brand, Botega aims to become a companion for people navigating stress, emotional exhaustion, and the challenges of daily life. We believe that taking care of yourself is not a luxury, but an essential part of maintaining balance and well-being.  Botega is also committed to empowering women who need support and opportunities to build a better future. Through our products, community, and purpose-driven initiatives, we strive to create a positive impact beyond our business. We hope to create a safe space where everyone can pause, breathe, reconnect with themselves, and remember that they deserve to feel cared for.',
            'pic'       => 'Evelyn Wijaya',
            'cat'       => 'Craft',
            'desc'      => 'Botega is a wellness brand creating sensory experiences through candles, soaps, perfumes, massage oils, and reed diffusers. We support emotional well-being, encourage self-care, and empower women through meaningful products and positive impact.',
            'tags'      => ['Craft', 'Kreatif', 'Transaksi Booth'],
            'logo'      => '',
            'contact'   => 'Evelinnewijaya@gmail.com',
            'whatsapp'  => '081333309993',
            'web'       => '',
            'instagram' => '@botega.id',
            'facebook'  => 'Botega Indonesia',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'h5',
            'booth_no'  => 85,
            'code'      => 'H5',
            'cluster'   => 6,
            'area'      => 'H',
            'name'      => 'allbouquets',
            'instansi'  => 'PASINBIS Universitas Airlangga',
            'pic'       => 'Alfi Laili Azizah',
            'cat'       => 'Craft',
            'desc'      => 'Allbouquets — buket bunga handmade custom sesuai tema & budget. Cocok untuk hadiah personal, wisuda, hingga gift event. Harga terjangkau, kualitas estetik, free ongkir via Shopee. Let\'s Celebrate Special Day with Special Bouquets! 🌸',
            'tags'      => ['Craft', 'Kreatif', 'Transaksi Booth'],
            'logo'      => 'https://drive.google.com/drive/folders/1p8xEmGyYPybUM27MGQLF_GcVTNHs-4Z-?usp=sharing',
            'contact'   => 'allbouquets12@gmail.com',
            'whatsapp'  => '085749884741',
            'web'       => '',
            'instagram' => 'https://www.instagram.com/allbouquets/',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'h6',
            'booth_no'  => 86,
            'code'      => 'H6',
            'cluster'   => 6,
            'area'      => 'H',
            'name'      => 'Etnapraya',
            'instansi'  => 'Etnapraya',
            'pic'       => 'Etty Ariaty Soraya',
            'cat'       => 'Craft',
            'desc'      => 'Etnapraya adalah merek tas lokal Indonesia yang menggabungkan keindahan budaya dan keahlian dalam setiap produknya. Setiap tas dibuat dari kulit asli berkualitas tinggi dihiasi dengan motif batik yang didesain ulang dengan indah, memadukan tradisi abadi dengan sentuhan desain modern.',
            'tags'      => ['Craft', 'Kreatif', 'Transaksi Booth'],
            'logo'      => 'https://lh3.googleusercontent.com/d/12CK3VGMZhsYBWSwbTQRssooqaZA9FNY-',
            'contact'   => 'etnapraya@gmail.com',
            'whatsapp'  => '+62 823-3819-1372',
            'web'       => 'https://etnapraya.com',
            'instagram' => 'Etnapraya',
            'facebook'  => 'Etnapraya',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'h7',
            'booth_no'  => 87,
            'code'      => 'H7',
            'cluster'   => 6,
            'area'      => 'H',
            'name'      => 'Quoversity',
            'instansi'  => 'QUOVERSITY',
            'pic'       => 'Muhammad Akbar Zulkarnain',
            'cat'       => 'Craft',
            'desc'      => 'Quoversity adalah brand merchandise yang mengangkat quote dan pemikiran guru besar serta akademisi ke dalam desain kaos. Menggabungkan intelektualitas, kreativitas, dan gaya, Quoversity menjadikan gagasan akademik sebagai bagian dari identitas dan keseharian.',
            'tags'      => ['Craft', 'Kreatif', 'Transaksi Booth'],
            'logo'      => '',
            'contact'   => 'akbarzulkarnain2303@gmail.com',
            'whatsapp'  => '085107733888',
            'web'       => '',
            'instagram' => '',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'h10',
            'booth_no'  => 90,
            'code'      => 'H10',
            'cluster'   => 6,
            'area'      => 'H',
            'name'      => 'AineMeara',
            'instansi'  => '-',
            'pic'       => 'Neina',
            'cat'       => 'Fashion',
            'desc'      => 'Ainemeara menyediakan beragam produk kerajinan tangan diantaranya bouquet & hampers hijab serta artificial flowers dengan pengiriman ke seluruh wilayah Indonesia',
            'tags'      => ['Fashion', 'Kreatif', 'Transaksi Booth'],
            'logo'      => 'https://drive.google.com/drive/folders/12gH6jh1EaibV_DayJiJn8dzNg928eNcS',
            'contact'   => 'ainemeara@gmail.com',
            'whatsapp'  => '082337701988',
            'web'       => '',
            'instagram' => 'https://www.instagram.com/ainemeara?igsh=MTZqb3Y1OGdkazNxOA==',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'h11',
            'booth_no'  => 91,
            'code'      => 'H11',
            'cluster'   => 6,
            'area'      => 'H',
            'name'      => 'Anka Mini Lab',
            'instansi'  => 'Tenant binaan PASINBIS Unuversitas Airlangga',
            'pic'       => 'Alify Yanura',
            'cat'       => 'Craft',
            'desc'      => 'Sabun dari bahan natural dan dibuat  handmade. Mampu memberikan perlindungan alami bagi kulit. Ramah dan aman bagi kulit sensitif',
            'tags'      => ['Craft', 'Kreatif', 'Transaksi Booth'],
            'logo'      => 'https://lh3.googleusercontent.com/d/14tLH8JysiAc7Fa62eXLcoEHKiRxQxctn',
            'contact'   => 'alifyayp@gmail.com',
            'whatsapp'  => '085755165911',
            'web'       => '',
            'instagram' => 'ankaminilab',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'h12',
            'booth_no'  => 92,
            'code'      => 'H12',
            'cluster'   => 6,
            'area'      => 'H',
            'name'      => 'ByLaw Nails',
            'instansi'  => 'Universitas Airlangga',
            'pic'       => 'Glorya Angela',
            'cat'       => 'Craft',
            'desc'      => 'ByLaw.Nails adalah brand kecantikan lokal yang bergerak di bidang press-on nails dengan menghadirkan produk kuku siap pakai yang praktis, reusable, customizable, dan stylish. ByLaw.Nails hadir sebagai solusi bagi konsumen yang ingin memiliki tampilan kuku yang cantik dan fashionable tanpa harus menghabiskan banyak waktu dan biaya untuk melakukan perawatan kuku di salon.

ByLaw.Nails menawarkan berbagai pilihan desain mulai dari desain minimalis, elegan, cute, hingga karakter dan tren populer yang dapat disesuaikan dengan preferensi pelanggan. Selain pilihan desain yang tersedia, pelanggan juga dapat melakukan custom order untuk menciptakan press-on nails yang lebih personal dan sesuai dengan karakter maupun kebutuhan mereka.

Dengan mengutamakan kualitas produk dan pengalaman pelanggan, setiap press-on nails dibuat melalui proses produksi yang memperhatikan detail, kerapian, dan estetika. Produk juga dirancang agar dapat digunakan kembali dengan perawatan yang tepat, sehingga memberikan nilai lebih bagi konsumen sekaligus mendukung penggunaan produk yang lebih berkelanjutan.

ByLaw.Nails menargetkan pasar Gen Z dan konsumen muda, khususnya mereka yang memiliki gaya hidup aktif, mengikuti tren kecantikan, dan menginginkan produk beauty yang praktis serta affordable. Pemasaran dilakukan secara digital melalui berbagai platform seperti TikTok, Instagram, dan Shopee untuk menjangkau konsumen secara lebih luas.
Ke depannya, ByLaw.Nails berkomitmen untuk terus mengembangkan inovasi produk, meningkatkan kualitas pelayanan, memperluas jangkauan pasar, serta membangun ekosistem bisnis kecantikan yang kreatif dan relevan dengan perkembangan tren. Dengan menggabungkan kreativitas, kualitas, dan kemudahan, ByLaw.Nails ingin menjadi salah satu brand press-on nails lokal yang dipercaya dan menjadi pilihan utama konsumen.',
            'tags'      => ['Craft', 'Kreatif', 'Transaksi Booth'],
            'logo'      => 'https://lh3.googleusercontent.com/d/1cPvRnvVUQmEWnMyFN7ZUBtcPegzgICqB',
            'contact'   => 'glorya.angela.marshanda-2023@feb.unair.ac.id',
            'whatsapp'  => '08115755656',
            'web'       => '',
            'instagram' => 'https://www.instagram.com/bylaw.nails/',
            'facebook'  => '',
            'twitter'   => 'https://www.instagram.com/bylaw.nails/',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'h13',
            'booth_no'  => 93,
            'code'      => 'H13',
            'cluster'   => 6,
            'area'      => 'H',
            'name'      => 'Studi Inkubator MUA',
            'instansi'  => 'Studi Inkubator MUA "Skill Up, Grow Up, and Glow Up"',
            'pic'       => 'Treesya',
            'cat'       => 'Jasa',
            'desc'      => 'Merupakan badan usaha yang menaungi komunitas para Makeup Artist di Surabaya untuk memberikan jasa layanan makeup yang profesional dan berkualitas',
            'tags'      => ['Jasa', 'Kreatif', 'Transaksi Booth'],
            'logo'      => 'https://canva.link/01bdnzrdocrhl0u',
            'contact'   => 'tresyagirls@gmail.com',
            'whatsapp'  => '085708342811',
            'web'       => '',
            'instagram' => 'studioinkubatormua',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'h14',
            'booth_no'  => 94,
            'code'      => 'H14',
            'cluster'   => 6,
            'area'      => 'H',
            'name'      => 'zarunagift',
            'instansi'  => 'universitas airlangga',
            'pic'       => 'Fito',
            'cat'       => 'Craft',
            'desc'      => 'Zaruna adalah brand yang bergerak di bidang gift, florist, dan custom souvenir yang menghadirkan berbagai produk untuk momen spesial seperti ulang tahun, wisuda, anniversary, hingga berbagai kebutuhan acara dan perusahaan.

Zaruna memiliki beberapa lini bisnis, yaitu Zaruna Florist untuk buket bunga dan karangan bunga, Zaruna Gift untuk produk custom dan souvenir, serta Zaruna Decoration untuk kebutuhan dekorasi acara.

Dengan mengutamakan kreativitas, personalisasi, harga yang terjangkau, dan pelayanan yang praktis, Zaruna membantu pelanggan menciptakan hadiah yang lebih personal dan berkesan. Pelanggan juga dapat melakukan custom desain sesuai kebutuhan tanpa harus terpaku pada produk yang sudah tersedia.

Zaruna berkomitmen untuk terus berinovasi dalam menghadirkan produk dan pengalaman yang relevan bagi generasi muda maupun kebutuhan bisnis, dengan semangat “We don’t just sell gifts, we deliver emotions.”',
            'tags'      => ['Craft', 'Kreatif', 'Transaksi Booth'],
            'logo'      => 'https://id.shp.ee/SHug2F2W',
            'contact'   => 'fito.fitroh1@gmail.com',
            'whatsapp'  => '089513370904',
            'web'       => 'http://msha.ke/zarunagift',
            'instagram' => 'zaruna.gift',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'b1',
            'booth_no'  => 97,
            'code'      => 'B1',
            'cluster'   => 7,
            'area'      => 'B',
            'name'      => 'Airlangga University Press (P3UA)',
            'instansi'  => 'Airlangga University Press (P3UA)',
            'pic'       => 'Sarah Khairunnisa',
            'cat'       => 'Internal UNAIR',
            'desc'      => 'Airlangga University Press (AUP) merupakan penerbit resmi Universitas Airlangga yang berkomitmen pada penerbitan akademik dan ilmiah yang berintegritas, profesional, dan berdaya saing global. Dengan menerbitkan buku akademik dari berbagai disiplin ilmu sebagai sarana diseminasi pengetahuan bagi sivitas akademika dan komunitas nasional maupun internasional.',
            'tags'      => ['Internal UNAIR', 'Transaksi Booth'],
            'logo'      => 'https://lh3.googleusercontent.com/d/1Rpa4jb4mTqsiOJPiPkU9QVWAkC71g4QB',
            'contact'   => 'sarah.khairunnisa@staf.unair.ac.id',
            'whatsapp'  => '085607811921',
            'web'       => 'https://omp.unair.ac.id',
            'instagram' => 'aupunair.official',
            'facebook'  => 'https://www.facebook.com/airlangga.press/',
            'twitter'   => 'twitter.com/aup_unair',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'b2',
            'booth_no'  => 98,
            'code'      => 'B2',
            'cluster'   => 7,
            'area'      => 'B',
            'name'      => 'Pusat Penelitian Stem Cell dan Kedokteran Regeneratif',
            'instansi'  => 'Pusat Penelitian Stem Cell dan Kedokteran Regeneratif',
            'pic'       => 'Asa Ardiana',
            'cat'       => 'Internal UNAIR',
            'desc'      => 'Laboratorium kami menyediakan informasi mengenai penelitian, program magang, produk turunan stem cell, serta konsultasi dan kolaborasi di bidang Stem Cell',
            'tags'      => ['Internal UNAIR', 'Transaksi Booth'],
            'logo'      => 'https://lh3.googleusercontent.com/d/1e7Qej_zcx-tB3ssmoFtrLfK6-jBbrubf',
            'contact'   => 'stemcell@itd.unair.ac.id',
            'whatsapp'  => '081325573848',
            'web'       => 'https://www.stemcell.unair.ac.id',
            'instagram' => 'unair.stemcell',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'b3',
            'booth_no'  => 99,
            'code'      => 'B3',
            'cluster'   => 7,
            'area'      => 'B',
            'name'      => 'PUI-PT RC-GERID (Pusat Unggulan IPTEKS Perguruan Tinggi Research Center on Global Emerging and Re-emerging Infectious Diseases, Universitas Airlangga)',
            'instansi'  => 'PUI-PT RC-GERID (Pusat Unggulan IPTEKS Perguruan Tinggi Research Center on Global Emerging and Re-emerging Infectious Diseases, Universitas Airlangga)',
            'pic'       => 'Aisah Nur Ana Bilah',
            'cat'       => 'Internal UNAIR',
            'desc'      => 'Research Center for Global Emerging and Re-emerging Infectious Diseases (RC GERID) merupakan pusat riset yang berfokus pada pengembangan ilmu pengetahuan, teknologi, dan produk inovatif untuk menghadapi ancaman penyakit infeksi emerging dan re-emerging melalui integrasi epidemiologi, biologi molekuler, mikrobiologi, genomik, bioinformatika, dan kesehatan masyarakat. RC GERID mengembangkan penelitian berbasis molecular epidemiology dan genomic surveillance yang diarahkan tidak hanya untuk menghasilkan publikasi dan bukti ilmiah.',
            'tags'      => ['Internal UNAIR', 'Transaksi Booth'],
            'logo'      => 'https://lh3.googleusercontent.com/d/1c_1sXc-PlidEdKDLjoNIx9YzaayhP41W',
            'contact'   => 'aisahanabilah@gmail.com',
            'whatsapp'  => '085854006650',
            'web'       => 'https://rc-gerid.unair.ac.id',
            'instagram' => 'https://www.instagram.com/rcgerid.unair/',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'b4',
            'booth_no'  => 100,
            'code'      => 'B4',
            'cluster'   => 7,
            'area'      => 'B',
            'name'      => 'PUI-PT Center of Excellence for Patient Safety and Quality',
            'instansi'  => 'PUI-PT Center of Excellence for Patient Safety and Quality (Pusat Riset Keselamatan Pasien) Universitas Airlangga',
            'pic'       => 'Luckyta',
            'cat'       => 'Internal UNAIR',
            'desc'      => 'PUI-PT Center of Excellence for Patient Safety and Quality (PUI-PT CoE-PSQ) merupakan pusat unggulan Universitas Airlangga yang berfokus pada pengembangan mutu pelayanan dan keselamatan pasien melalui pendidikan, penelitian, dan advokasi.

Dalam booth ini, PUI-PT CoE-PSQ memperkenalkan berbagai produk dan layanan unggulan yang mendukung edukasi serta peningkatan keselamatan pasien, antara lain buku keselamatan pasien Jilid 1–3, buku cerita pasien dalam 6 seri, serta layanan konsultasi di bidang mutu dan keselamatan pasien. Selain itu, tersedia berbagai merchandise PUI-PT CoE-PSQ dengan identitas dan desain khusus, seperti payung, notebook, mug, dan tote bag.

Berbagai produk dan layanan tersebut merupakan bagian dari upaya PUI-PT CoE-PSQ dalam menyebarluaskan pengetahuan, meningkatkan kesadaran mengenai keselamatan pasien, serta mendukung penerapan mutu dan keselamatan pasien di berbagai lingkungan pelayanan kesehatan.',
            'tags'      => ['Internal UNAIR', 'Transaksi Booth'],
            'logo'      => 'https://drive.google.com/drive/folders/1hK1rhJusVWjvCy74OKjQreLTdbbhqwXR?usp=sharing',
            'contact'   => 'prkp@unair.ac.id',
            'whatsapp'  => '085732939252',
            'web'       => 'https://patientsafety.unair.ac.id',
            'instagram' => 'pusatrisetkeselamatanpasien',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'b5',
            'booth_no'  => 101,
            'code'      => 'B5',
            'cluster'   => 7,
            'area'      => 'B',
            'name'      => 'Airlangga Institute for Learning and Growth (AILG) Univeristas Airlangga',
            'instansi'  => 'Airlangga Institute for Learning and Growth (AILG) Univeristas Airlangga',
            'pic'       => 'Nuzul Alya',
            'cat'       => 'Internal UNAIR',
            'desc'      => 'AILG adalah pusat unggulan yang didirikan oleh Universitas Airlangga untuk mendukung perkembangan profesional dan pribadi masyarakat luas. AILG membawahi 9 Center Unggulan Unair yang menawarkan berbagai program penelitian, kajian, konsultasi, pelatihan, dan workshop yang dirancang untuk memperluas pengetahuan serta keterampilan dalam berbagai bidang, mulai dari manajemen, teknologi informasi, sains hingga ilmu sosial.',
            'tags'      => ['Internal UNAIR', 'Transaksi Booth'],
            'logo'      => 'https://drive.google.com/drive/folders/1i4gwNByphxAS0gaw-TSpZLLIBQmIa73v?usp=sharing',
            'contact'   => 'ailg@unair.ac.id',
            'whatsapp'  => '085888991515',
            'web'       => 'https://ailg.unair.ac.id',
            'instagram' => '@ailg_unair',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'b6',
            'booth_no'  => 102,
            'code'      => 'B6',
            'cluster'   => 7,
            'area'      => 'B',
            'name'      => 'PUI-PT SCT',
            'instansi'  => 'Fakultas Farmasi',
            'pic'       => 'Prof. Tristiana Erawati Munandar, M.Si. Apt.',
            'cat'       => 'Internal UNAIR',
            'desc'      => 'PUI-PT Kesehatan Kulit dan Teknologi Kosmetik ( Skin and Cosmetic Technology (SCT) Centre of Excellent ) is a part of the Faculty of Pharmacy, Universitas Airlangga. This research group was founded for pharmaceutical sciences excellence. Main research of this research group are cosmetic delivery system and its evaluation to produce cosmetic preparations with quality standards and requirements (stable, effective, safe, and acceptable). The studies are anti-aging preparations, sunscreens, skincare, and hair extension. In the successful execution of its range of activities and services, the PUIPT-SCT organization necessitates and effectively leverages the power of information technology.',
            'tags'      => ['Internal UNAIR', 'Transaksi Booth'],
            'logo'      => 'https://lh3.googleusercontent.com/d/1-ApGhhrsD3s-ghsGL7yKP7uzbHcFXtbW',
            'contact'   => 'puipt-sct@ff.unair.ac.id',
            'whatsapp'  => '+62 812-1671-607',
            'web'       => 'https://puiptsct.ff.unair.ac.id/',
            'instagram' => '',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'b7',
            'booth_no'  => 103,
            'code'      => 'B7',
            'cluster'   => 7,
            'area'      => 'B',
            'name'      => 'DPA Group',
            'instansi'  => 'PT. Dharma Putra Airlangga',
            'pic'       => 'Delfa Plezia',
            'cat'       => 'Internal UNAIR',
            'desc'      => 'Holding Company of Universitas Airlangga - Airlangga Global Travelling AGT), Inovasi Bioproduk Indonesia (Inobi), PT. Abhiseka Bangun Sarana, PT. Airlangga Univ Konsultan, PT. Dharma Putra Adigraha.',
            'tags'      => ['Internal UNAIR', 'Transaksi Booth'],
            'logo'      => 'https://drive.google.com/drive/folders/1ZoLBNhb5I3S3CSoxOeVPItbryFUSUdGR?usp=sharing',
            'contact'   => 'info@airlanggatravel.com / admin@dpacorp.id',
            'whatsapp'  => '+62 838-4636-3901',
            'web'       => '',
            'instagram' => 'https://www.instagram.com/dpa.corp',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'b8',
            'booth_no'  => 104,
            'code'      => 'B8',
            'cluster'   => 7,
            'area'      => 'B',
            'name'      => 'Pemeriksaan Gigi Gratis RSGM UNAIR',
            'instansi'  => 'RSGM UNAIR',
            'pic'       => 'drg. Vankalayya Y. D',
            'cat'       => 'Internal UNAIR',
            'desc'      => 'RSGM UNAIR berpartisipasi dalam Industry Matching IM ASSIE IV 2026 sebagai wadah untuk memperkenalkan layanan, inovasi, dan pengembangan teknologi di bidang kesehatan gigi dan mulut serta membuka peluang kolaborasi strategis dengan berbagai pihak.',
            'tags'      => ['Internal UNAIR', 'Transaksi Booth'],
            'logo'      => 'https://drive.google.com/drive/folders/1FmNKtkSUw2RZbACH8OY3aG-uPaMhK4MF?hl=id',
            'contact'   => 'adm@rsgm.unair.ac.id',
            'whatsapp'  => '081335158286',
            'web'       => 'https://rsgm.unair.ac.id/',
            'instagram' => 'rsgmunair',
            'facebook'  => 'RSGM UNAIR',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'b9',
            'booth_no'  => 105,
            'code'      => 'B9',
            'cluster'   => 7,
            'area'      => 'B',
            'name'      => 'RSH Universitas Airlangga',
            'instansi'  => 'Rumah Sakit Hewan Universitas Airlangga',
            'pic'       => 'Abihilla Zikra Taim, drh',
            'cat'       => 'Internal UNAIR',
            'desc'      => 'Booth Rumah Sakit Hewan (RSH) Universitas Airlangga merupakan sarana edukasi dan informasi mengenai layanan kesehatan hewan yang disediakan oleh RSH UNAIR. Melalui booth ini, pengunjung dapat mengenal berbagai layanan, seperti pemeriksaan kesehatan, vaksinasi, konsultasi dokter hewan, tindakan medis, serta edukasi mengenai perawatan dan kesejahteraan hewan. Selain memperkenalkan fasilitas dan layanan, booth ini juga menjadi media untuk meningkatkan kesadaran masyarakat tentang pentingnya menjaga kesehatan hewan sebagai bagian dari kesehatan lingkungan. Dengan konsep yang informatif dan interaktif, Booth RSH Universitas Airlangga diharapkan dapat memberikan pengalaman edukatif sekaligus mempererat hubungan antara institusi, tenaga medis veteriner, dan masyarakat.',
            'tags'      => ['Internal UNAIR', 'Transaksi Booth'],
            'logo'      => 'https://lh3.googleusercontent.com/d/1Zdty7y5HGkxdbUmVDj986RSpWaUgYBZP',
            'contact'   => 'abihilalzikra.taim@gmail.com',
            'whatsapp'  => '082186484622',
            'web'       => 'https://www.rsh.unair.ac.id',
            'instagram' => 'rsh.unair',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
        [
            'id'        => 'b10',
            'booth_no'  => 106,
            'code'      => 'B10',
            'cluster'   => 7,
            'area'      => 'B',
            'name'      => 'Rumah Sakit Universitas Airlangga',
            'instansi'  => 'Rumah Sakit Universitas Airlangga',
            'pic'       => 'Prisma Andita Pebriaini, S.KM., M.Kes',
            'cat'       => 'Internal UNAIR',
            'desc'      => 'Rumah Sakit Universitas Airlangga sebagai academic teaching hospital, mengintegrasikan pendidikan, penelitian, dan layanan kesehatan unggul. Berorientasi pada pelayanan pasien, inovasi, kolaborasi internasional, serta pengembangan medical tourism.',
            'tags'      => ['Internal UNAIR', 'Transaksi Booth'],
            'logo'      => 'https://bit.ly/LOGORESMI_RSUNAIR',
            'contact'   => 'riset.rsua2019@gmail.com',
            'whatsapp'  => '085728059595',
            'web'       => 'https://rumahsakit.unair.ac.id/',
            'instagram' => 'rs.unair',
            'facebook'  => '',
            'twitter'   => '',
            'transaksi' => 'Ya',
        ],
    ];
}
function assie4_default_tenant_logos() {
    $base = ASSIE4_PAMERAN_URL . 'assets/tenant-logos/';
    $files = [
        'a1'  => 'LOGO FK UNAIR 2025.jpg.jpeg',
        'a2'  => 'Logo FKG.png',
        'a3'  => 'fakultas farmasi outline.png',
        'a4'  => 'FKH UNAIR Logo ALternatif.png',
        'a5'  => '29_FST_UNAIR.png',
        'a6'  => 'LOGONEW_FTMM_forLightBG-Colour.png',
        'a7'  => 'logo-sigap-Fakultas Vokasi.png',
        'a8'  => 'FPK UNAIR (3).png',
        'a10' => 'logo header sosmed fkm.png',
        'a11' => 'LOGO-FIB-UNAIR.png',
        'a12' => 'LOGO FIKKIA (1).png',
        'a16' => 'lembaga-penyakit-tropis.webp',
        'a17' => 'Logo Airlangga Enterprise.jpg',
        'a19' => 'Puspas HD.png',
        'a20' => 'Logo Pushal x LPH.png',
        'a21' => 'Logo pusba_kotak final.png',
        'd1'  => 'AirBiliSun (1).jpg',
        'd2'  => 'Logo CESGS.png',
        'd5'  => 'Logo Madu Onggu Recreate-03.png',
        'd6'  => 'Logo Kopi Setengah Serius.jpg',
        'd9'  => 'LOGO FLORDEQUEEN OFFICIAL.png',
        'd11' => 'logo ulul albab uin malang.png',
        'c1'  => 'Badan POM White Outline.png',
        'f1'  => 'Logo Bangga EVCS.png',
        'f2'  => 'Copy of Kinara Industries-Logo 2.png',
        'f3'  => 'Logo Olimnesia.jpg',
        'f4'  => 'JOBHUN HITAM border.png',
        'f5'  => 'Logo Serasa Djiwa.png',
        'f6'  => 'Logo Rexgo.png',
        'f8'  => 'Logo Lokasi Nusantara.png',
        'f10' => 'Logo + Tulisan Tempat Tumbuh.png',
        'f11' => 'logo Fast Track Edu.png',
        'f12' => 'Logo Vitalic Hit.png',
        'f13' => 'Logo Konveto for Sponsor.png',
        'f14' => 'Logo Heztek Coding - 1.png',
        'f15' => 'logo braja.png',
        'f17' => 'Logo APPA Tech.png',
        'f18' => 'Logo Likur Production.png',
        'g1'  => 'LOGO DEORANS.png',
        'g2'  => 'Logo Tawdeo.png',
        'g4'  => 'Logo Sweet Food.jpg',
        'g5'  => 'Logo Golden Gate Dimsum.png',
        'g6'  => 'Logo Lammaq Banna.png',
        'g7'  => 'Logo Ayam Ungkep Teh Nisa.jpg',
        'h1'  => 'Logo Gyarus.jpeg',
        'h2'  => 'Logo Leastra.png',
        'h6'  => 'logo-300-x-300 Etna Praya.png',
        'h11' => 'Logo ANKA .jpg',
        'h12' => 'LOGO ByLaw Nails.png',
        'h13' => 'Logo Studio Inkubator MUA.png',
        'b2'  => 'Pusat Penelitian Stem Cell dan Kedokteran Regeneratif.jpeg',
        'b3'  => 'Logo RC-Gerid.jpg',
        'b4'  => 'Logo PUI-PT CoE-PSQ 2025.png',
        'b5'  => 'Logo AILG (hitam).png',
        'b6'  => 'Salinan Salinan LOGO SCT.png',
        'b7'  => 'LOGO DPA.png',
        'b8'  => 'Logo RSGM Unair.jpg',
        'b9'  => 'Pylon Sign RSH Unair.png',
    ];

    $logos = [];
    $asset_dir = dirname(__DIR__) . '/assets/tenant-logos/';
    foreach ($files as $tenant_id => $filename) {
        if (is_file($asset_dir . $filename)) {
            $logos[$tenant_id] = $base . rawurlencode($filename);
        }
    }

    return $logos;
}
function assie4_default_rundown() {
    return [
        'days'   => [['label'=>'Jumat, 6 November 2026'],['label'=>'Sabtu, 7 November 2026'],['label'=>'Minggu, 8 November 2026']],
        'events' => [
            ['day'=>0,'time'=>'13.00','end'=>'15.30','name'=>'Airlangga Business Matching 2026 - ATAVI','type'=>'panel','loc'=>'Ruang Business Matching'],
            ['day'=>0,'time'=>'15.30','end'=>'17.00','name'=>'Opening Ceremony + Launching Produk Inovasi','type'=>'keynote','loc'=>'Main Stage'],
            ['day'=>0,'time'=>'17.00','end'=>'17.30','name'=>'Break',                              'type'=>'break',    'loc'=>'—'],
            ['day'=>0,'time'=>'17.30','end'=>'19.30','name'=>'Roblox Competition',                 'type'=>'workshop', 'loc'=>'Hall'],
            ['day'=>0,'time'=>'19.45','end'=>'20.45','name'=>'Acoustic Band Performance',          'type'=>'networking','loc'=>'Main Stage'],
            ['day'=>0,'time'=>'21.00','end'=>'21.30','name'=>'Closing Day 1',                      'type'=>'award',    'loc'=>'Main Stage'],
            ['day'=>1,'time'=>'10.00','end'=>'10.30','name'=>'Opening',                            'type'=>'keynote',  'loc'=>'Main Stage'],
            ['day'=>1,'time'=>'10.30','end'=>'13.40','name'=>'Workshop Beregu Startup ATAVI',      'type'=>'workshop', 'loc'=>'Hall'],
            ['day'=>1,'time'=>'13.50','end'=>'18.00','name'=>'Mozilla Legend E-Sport Competition', 'type'=>'workshop', 'loc'=>'Hall'],
            ['day'=>1,'time'=>'19.40','end'=>'20.40','name'=>'Acoustic Band Perform',              'type'=>'networking','loc'=>'Main Stage'],
            ['day'=>1,'time'=>'20.40','end'=>'21.10','name'=>'Closing Day 2',                      'type'=>'award',    'loc'=>'Main Stage'],
            ['day'=>2,'time'=>'10.00','end'=>'10.05','name'=>'Opening',                            'type'=>'keynote',  'loc'=>'Main Stage'],
            ['day'=>2,'time'=>'10.05','end'=>'12.35','name'=>'ASSIE El Got Talent',                'type'=>'networking','loc'=>'Main Stage'],
            ['day'=>2,'time'=>'13.05','end'=>'15.05','name'=>'Talkshow Science Behind Glowing Skin','type'=>'panel',  'loc'=>'Main Stage'],
            ['day'=>2,'time'=>'15.35','end'=>'16.35','name'=>'El Got Talent',                      'type'=>'networking','loc'=>'Main Stage'],
            ['day'=>2,'time'=>'16.35','end'=>'18.55','name'=>'Acoustic Band Perform',              'type'=>'networking','loc'=>'Main Stage'],
            ['day'=>2,'time'=>'18.55','end'=>'20.00','name'=>'Closing Ceremony',                   'type'=>'award',    'loc'=>'Main Stage'],
        ],
    ];
}

/* ═══ HELPERS ═══════════════════════════════════════════ */
function assie4_get_tenants() {
    $raw = get_option( ASSIE4_OPT_TENANTS, [] );
    if ( ! is_array($raw) ) $raw = [];
    $seed_state = get_option( 'assie4_directory_seed_state' );

    $has_old_dummy = false;
    foreach ($raw as $t) {
        if (isset($t['id']) && in_array($t['id'], ['b13', 'b16', 'c10', 'd10', 'd11', 'e15'], true) && empty($t['instansi'])) {
            $has_old_dummy = true;
            break;
        }
    }
    if ( empty($raw) || $has_old_dummy || $seed_state !== 'v5' ) {
        $raw = assie4_default_tenants();
        update_option( ASSIE4_OPT_TENANTS, $raw, false );
        update_option( 'assie4_directory_seed_state', 'v5', false );
        assie4_rebuild_js_data();
    }

    // Replace remote default logo URLs once, without overwriting logos uploaded to this site.
    if ( get_option( 'assie4_local_tenant_logos_version' ) !== '1' ) {
        $local_logos = assie4_default_tenant_logos();
        $site_host = wp_parse_url( home_url( '/' ), PHP_URL_HOST );
        $logos_changed = false;

        foreach ( $raw as &$tenant ) {
            $tenant_id = sanitize_key( $tenant['id'] ?? '' );
            if ( ! isset( $local_logos[$tenant_id] ) ) {
                continue;
            }

            $current_logo = trim( (string) ( $tenant['logo'] ?? '' ) );
            $logo_host = $current_logo !== '' ? wp_parse_url( $current_logo, PHP_URL_HOST ) : '';
            if ( $logo_host && $site_host && strcasecmp( $logo_host, $site_host ) === 0 ) {
                continue;
            }

            $tenant['logo'] = $local_logos[$tenant_id];
            $logos_changed = true;
        }
        unset( $tenant );

        if ( $logos_changed ) {
            update_option( ASSIE4_OPT_TENANTS, $raw, false );
            assie4_rebuild_js_data();
        }
        update_option( 'assie4_local_tenant_logos_version', '1', false );
    }

    return array_values( array_map( 'assie4_normalize_tenant', $raw ) );
}
function assie4_save_tenants( $tenants ) {
    $tenants = array_values( array_map( 'assie4_normalize_tenant', $tenants ) );
    usort( $tenants, function($a, $b) {
        $b_no_a = $a['booth_no'] ?: 999;
        $b_no_b = $b['booth_no'] ?: 999;
        if ($b_no_a !== $b_no_b) return $b_no_a <=> $b_no_b;
        return strcmp($a['id'], $b['id']);
    });
    update_option( ASSIE4_OPT_TENANTS, $tenants, false );
    update_option( 'assie4_directory_seed_state', 'v5', false );
    assie4_rebuild_js_data();
    return $tenants;
}
function assie4_rebuild_js_data() {
    update_option( 'assie4_pameran_cache_ver', time() );
}

/* ── Render notice ── */
function a4_notice( $msg, $cls = 'ok' ) {
    echo '<div class="a4-notice a4-' . esc_attr($cls) . '">' . esc_html($msg) . '</div>';
}

/* ── Page header helper ── */
function a4_header( $title, $sub = '' ) {
    $p   = get_page_by_path( ASSIE4_PAMERAN_SLUG );
    $url = $p ? get_permalink($p) : home_url('/'.ASSIE4_PAMERAN_SLUG.'/');
    echo '<div class="a4-wrap">';
    echo '<div class="a4-nav-bar">';
    echo '<a href="' . admin_url('admin.php?page=assie4-pameran') . '">🎪 ASSIE IV</a>';
    echo '<span>›</span>';
    echo '<span>' . esc_html($title) . '</span>';
    echo '</div>';
    echo '<div class="a4-page-header">';
    echo '<h1>' . esc_html($title);
    if ($sub) echo ' <span class="a4-badge a4-badge-gold">' . esc_html($sub) . '</span>';
    echo '</h1>';
    echo '<a href="' . esc_url($url) . '" target="_blank" class="a4-btn-gold u-text-xs u-whitespace-nowrap" style="padding:7px 14px">🔗 Lihat Halaman Pameran</a>';
    echo '</div>';
    // a4-wrap ditutup di akhir setiap fungsi
}

/* ═══ ADMIN MENU ════════════════════════════════════════ */
if ( is_admin() ) {
    add_action( 'admin_menu', 'assie4_register_admin_menus' );
}
function assie4_register_admin_menus() {
    add_menu_page( 'ASSIE IV Pameran','ASSIE IV Pameran','manage_options','assie4-pameran','assie4_admin_dashboard','dashicons-store',56 );
    add_submenu_page('assie4-pameran','Dashboard',     'Dashboard',     'manage_options','assie4-pameran',  'assie4_admin_dashboard');
    add_submenu_page('assie4-pameran','Info Acara',    'Info Acara',    'manage_options','assie4-info',     'assie4_admin_info');
    add_submenu_page('assie4-pameran','Hero Slider',   'Hero Slider',   'manage_options','assie4-slides',   'assie4_admin_slides');
    add_submenu_page('assie4-pameran','Ticker',        'Ticker',        'manage_options','assie4-ticker',   'assie4_admin_ticker');
    add_submenu_page('assie4-pameran','Rundown',       'Rundown',       'manage_options','assie4-rundown',  'assie4_admin_rundown');
    add_submenu_page('assie4-pameran','Kelola Tenant', 'Kelola Tenant', 'manage_options','assie4-tenants',  'assie4_admin_tenants');
    add_submenu_page('assie4-pameran','Denah & Galeri','Denah & Galeri','manage_options','assie4-denah',    'assie4_admin_denah');
    add_submenu_page('assie4-pameran','Booth PASINBIS','Booth PASINBIS','manage_options','assie4-pasinbis', 'assie4_admin_pasinbis');
    add_submenu_page('assie4-pameran','Export/Reset',  'Export/Reset',  'manage_options','assie4-export',   'assie4_admin_export');
    add_submenu_page('assie4-pameran','Berita Eksternal','Berita Eksternal','manage_options','assie4-berita-ext','assie4_admin_berita_ext');
}

/* ═══ ENQUEUE ═══════════════════════════════════════════ */
if ( is_admin() ) {
    add_action( 'admin_enqueue_scripts', 'assie4_admin_enqueue_scripts' );
}
function assie4_admin_enqueue_scripts( $hook ) {
    $our = [
        'toplevel_page_assie4-pameran',
        'assie4-pameran_page_assie4-info',
        'assie4-pameran_page_assie4-slides',
        'assie4-pameran_page_assie4-ticker',
        'assie4-pameran_page_assie4-rundown',
        'assie4-pameran_page_assie4-tenants',
        'assie4-pameran_page_assie4-denah',
        'assie4-pameran_page_assie4-pasinbis',
        'assie4-pameran_page_assie4-export',
    ];
    if ( ! in_array( $hook, $our, true ) ) return;

    wp_enqueue_style( 'assie4-admin-css', ASSIE4_PAMERAN_URL . 'assets/assie4-admin.css', [], ASSIE4_PAMERAN_VER );
    if ( $hook === 'assie4-pameran_page_assie4-denah' ) {
        wp_enqueue_media();
    }
}

/* ═══ 1. DASHBOARD ══════════════════════════════════════ */
function assie4_admin_dashboard() {
    $tenants = assie4_get_tenants();
    $rd      = get_option( ASSIE4_OPT_RUNDOWN, assie4_default_rundown() );
    $p       = get_page_by_path( ASSIE4_PAMERAN_SLUG );
    $url     = $p ? get_permalink($p) : home_url('/'.ASSIE4_PAMERAN_SLUG.'/');

    echo '<div class="a4-wrap wrap">';
    echo '<div class="a4-page-header">';
    echo '<h1>🎪 ASSIE IV Pameran Digital <span class="a4-badge a4-badge-gold">v2.8</span></h1>';
    echo '<a href="' . esc_url($url) . '" target="_blank" class="a4-btn-gold u-text-xs u-whitespace-nowrap" style="padding:7px 14px">🔗 Lihat Halaman Pameran</a>';
    echo '</div>';

    // Stats
    echo '<div class="a4-stat-box">';
    echo '<div class="a4-stat"><span class="a4-stat-n">' . count($tenants) . '</span><span class="a4-stat-l">Tenant</span></div>';
    echo '<div class="a4-stat"><span class="a4-stat-n">' . count(get_option(ASSIE4_OPT_SLIDES,assie4_default_slides())) . '</span><span class="a4-stat-l">Slide Hero</span></div>';
    echo '<div class="a4-stat"><span class="a4-stat-n">' . count($rd['events']??[]) . '</span><span class="a4-stat-l">Event Rundown</span></div>';
    echo '<div class="a4-stat"><span class="a4-stat-n">' . count(get_option(ASSIE4_OPT_TICKER,assie4_default_ticker())) . '</span><span class="a4-stat-l">Ticker</span></div>';
    echo '<div class="a4-stat"><span class="a4-stat-n">' . count(get_option('assie4_pameran_denah',[])) . '</span><span class="a4-stat-l">Foto Denah</span></div>';
    echo '</div>';

    // Menu grid
    $menus = [
        ['assie4-info',    '📅','Info Acara',    'Tanggal, lokasi, jam operasional'],
        ['assie4-slides',  '🖼️','Hero Slider',   'Slide, gambar, dan CTA'],
        ['assie4-ticker',  '📢','Ticker',         'Teks berjalan bawah hero'],
        ['assie4-rundown', '🗓️','Rundown',        'Jadwal acara 3 hari'],
        ['assie4-tenants', '🏪','Kelola Tenant',  'Tambah, edit, hapus booth'],
        ['assie4-denah',   '🗺️','Denah & Galeri', 'Upload foto denah booth'],
        ['assie4-pasinbis','🏢','Booth PASINBIS', 'URL dan info booth PASINBIS'],
        ['assie4-export',  '💾','Export/Reset',   'Backup JSON & reset data'],
    ];
    echo '<div class="a4-card">';
    echo '<div class="a4-card-head">Menu Pengaturan</div>';
    echo '<div class="a4-menu-grid">';
    foreach ( $menus as [$sl, $ico, $lb, $dc] ) {
        echo '<a href="' . admin_url('admin.php?page='.$sl) . '" class="a4-menu-item">';
        echo '<span class="a4-menu-icon">' . $ico . '</span>';
        echo '<span class="a4-menu-label">' . esc_html($lb) . '</span>';
        echo '<span class="a4-menu-desc">' . esc_html($dc) . '</span>';
        echo '</a>';
    }
    echo '</div></div>';

    // Info
    echo '<div class="a4-card">';
    echo '<div class="a4-card-head">Info Plugin</div>';
    echo '<table class="a4-info-table">';
    echo '<tr><th>URL Halaman Pameran</th><td><a href="'.esc_url($url).'" target="_blank">'.esc_url($url).'</a></td></tr>';
    echo '<tr><th>Shortcode</th><td><code>[assie4_pameran]</code></td></tr>';
    echo '<tr><th>Status Halaman</th><td>' . ($p ? '<span class="a4-badge a4-badge-green">Published</span>' : '<span class="a4-badge a4-badge-red">Belum dibuat</span>') . '</td></tr>';
    echo '<tr><th>Versi</th><td>2.8.1</td></tr>';
    echo '<tr><th>PHP Version</th><td>'.esc_html(PHP_VERSION).'</td></tr>';
    echo '<tr><th>WordPress Version</th><td>'.esc_html($GLOBALS['wp_version']).'</td></tr>';
    echo '</table></div>';
    echo '</div>';
}

/* ═══ 2. INFO ACARA ═════════════════════════════════════ */
function assie4_admin_info() {
    if ( ! current_user_can('manage_options') ) return;
    if ( isset($_POST['_n']) && wp_verify_nonce($_POST['_n'],'a4_info') ) {
        update_option( ASSIE4_OPT_INFO, [
            'logo'      => esc_url_raw($_POST['logo']      ?? ''),
            'date'      => sanitize_text_field($_POST['date']      ?? ''),
            'location'  => sanitize_text_field($_POST['location']  ?? ''),
            'org'       => sanitize_text_field($_POST['org']       ?? ''),
            'timeOpen'  => sanitize_text_field($_POST['timeOpen']  ?? '08:00'),
            'timeClose' => sanitize_text_field($_POST['timeClose'] ?? '20:00'),
        ] );
        assie4_rebuild_js_data();
        a4_notice('✅ Info acara berhasil disimpan!');
    }
    $i = get_option( ASSIE4_OPT_INFO, assie4_default_info() );
    a4_header('Info Acara');
    ?>
    <div class="a4-card">
        <div class="a4-card-head">Informasi Acara</div>
        <form method="post"><?php wp_nonce_field('a4_info','_n'); ?>
        <div class="a4-field" style="margin-bottom:14px">
            <label>Logo Kegiatan <small>(URL gambar atau path aset)</small></label>
            <div style="display:flex;gap:12px;align-items:center">
                <input name="logo" value="<?php echo esc_attr(!empty($i['logo']) ? $i['logo'] : (ASSIE4_PAMERAN_URL . 'assets/logo-assie4.png')); ?>" style="flex:1">
                <?php
                $cur_logo = !empty($i['logo']) ? $i['logo'] : (ASSIE4_PAMERAN_URL . 'assets/logo-assie4.png');
                ?>
                <img src="<?php echo esc_url($cur_logo); ?>" style="height:36px;background:#fff;padding:3px 8px;border-radius:6px;border:1px solid #ddd;box-shadow:0 1px 3px rgba(0,0,0,0.1)" alt="Preview Logo">
            </div>
            <small style="color:#666">Logo default: <code>assets/logo-assie4.png</code> (Industry Matching ASSIE IV 2026)</small>
        </div>
        <div class="a4-row">
            <div class="a4-field"><label>Tanggal Acara</label><input name="date" value="<?php echo esc_attr($i['date']); ?>" placeholder="6-8 November 2026"></div>
            <div class="a4-field"><label>Penyelenggara</label><input name="org" value="<?php echo esc_attr($i['org']); ?>"></div>
        </div>
            <div class="a4-field" style="margin-bottom:14px"><label>Lokasi / Venue</label><input name="location" value="<?php echo esc_attr($i['location']); ?>"></div>
        <div class="a4-row">
            <div class="a4-field"><label>Jam Buka</label><input type="time" name="timeOpen" value="<?php echo esc_attr($i['timeOpen']); ?>"></div>
            <div class="a4-field"><label>Jam Tutup</label><input type="time" name="timeClose" value="<?php echo esc_attr($i['timeClose']); ?>"></div>
        </div>
        <button type="submit" class="a4-btn-primary">💾 Simpan Info Acara</button>
        </form>
    </div>
    </div>
    <?php
}

/* ═══ 3. SLIDES ═════════════════════════════════════════ */
function assie4_admin_slides() {
    if ( ! current_user_can('manage_options') ) return;
    if ( isset($_POST['_n']) && wp_verify_nonce($_POST['_n'],'a4_slides') ) {
        $sl = [];
        foreach ( ($_POST['s_title'] ?? []) as $i => $t ) {
            $sl[] = ['title'=>sanitize_text_field($t),'subtitle'=>sanitize_text_field($_POST['s_subtitle'][$i]??''),'desc'=>sanitize_textarea_field($_POST['s_desc'][$i]??''),'cta'=>sanitize_text_field($_POST['s_cta'][$i]??''),'link'=>esc_url_raw($_POST['s_link'][$i]??''),'bg'=>sanitize_text_field($_POST['s_bg'][$i]??'')];
        }
        update_option( ASSIE4_OPT_SLIDES, $sl );
        assie4_rebuild_js_data();
        a4_notice('✅ Hero slider disimpan!');
    }
    $slides = get_option( ASSIE4_OPT_SLIDES, assie4_default_slides() );
    a4_header('Hero Slider', count($slides).' slide');
    ?>
    <form method="post"><?php wp_nonce_field('a4_slides','_n'); ?>
    <div id="a4SW">
    <?php foreach ( $slides as $i => $s ) : ?>
    <div class="a4-item-box">
        <div class="a4-item-header">
            <span class="a4-item-num">🖼 Slide <?php echo $i+1 ?></span>
            <button type="button" class="a4-btn-del" onclick="this.closest('.a4-item-box').remove()">✕ Hapus</button>
        </div>
        <div class="a4-row">
            <div class="a4-field"><label>Judul Besar</label><input name="s_title[]" value="<?php echo esc_attr($s['title']); ?>"></div>
            <div class="a4-field"><label>Sub Judul</label><input name="s_subtitle[]" value="<?php echo esc_attr($s['subtitle']); ?>"></div>
        </div>
        <div class="a4-field u-mb-md"><label>Deskripsi</label><textarea name="s_desc[]" rows="2"><?php echo esc_textarea($s['desc']); ?></textarea></div>
        <div class="a4-row">
            <div class="a4-field"><label>Teks Tombol CTA</label><input name="s_cta[]" value="<?php echo esc_attr($s['cta']); ?>"></div>
            <div class="a4-field"><label>Link Tombol</label><input name="s_link[]" value="<?php echo esc_attr($s['link']); ?>"></div>
        </div>
        <div class="a4-field"><label>Background <small>(URL gambar https://... atau CSS gradient)</small></label><input name="s_bg[]" value="<?php echo esc_attr($s['bg']); ?>" placeholder="https://domain.com/foto.jpg atau linear-gradient(...)"></div>
    </div>
    <?php endforeach; ?>
    </div>
    <button type="button" class="a4-btn-add" onclick="a4AS()">＋ Tambah Slide</button><br><br>
    <button type="submit" class="a4-btn-primary">💾 Simpan Semua Slide</button>
    </form>
    </div>
    <script>
    function a4AS(){document.getElementById('a4SW').insertAdjacentHTML('beforeend','<div class="a4-item-box"><div class="a4-item-header"><span class="a4-item-num">🖼 Slide Baru</span><button type="button" class="a4-btn-del" onclick="this.closest(\'.a4-item-box\').remove()">✕ Hapus</button></div><div class="a4-row"><div class="a4-field"><label>Judul</label><input name="s_title[]" value=""></div><div class="a4-field"><label>Sub Judul</label><input name="s_subtitle[]" value="ASSIE IV 2026"></div></div><div class="a4-field" style="margin-bottom:12px"><label>Deskripsi</label><textarea name="s_desc[]" rows="2"></textarea></div><div class="a4-row"><div class="a4-field"><label>Teks Tombol</label><input name="s_cta[]" value="Selengkapnya"></div><div class="a4-field"><label>Link</label><input name="s_link[]" value="#denah"></div></div><div class="a4-field"><label>Background (URL gambar atau CSS)</label><input name="s_bg[]" value="linear-gradient(135deg,#03050e,#0c1a40)"></div></div>');}
    </script>
    <?php
}

/* ═══ 4. TICKER ═════════════════════════════════════════ */
function assie4_admin_ticker() {
    if ( ! current_user_can('manage_options') ) return;
    if ( isset($_POST['_n']) && wp_verify_nonce($_POST['_n'],'a4_ticker') ) {
        $items = array_values( array_filter( array_map( 'sanitize_text_field', explode("\n", $_POST['ticker'] ?? '') ) ) );
        update_option( ASSIE4_OPT_TICKER, $items );
        assie4_rebuild_js_data();
        a4_notice('✅ Ticker disimpan!');
    }
    $t = get_option( ASSIE4_OPT_TICKER, assie4_default_ticker() );
    a4_header('Ticker', count($t).' item');
    ?>
    <div class="a4-card">
        <div class="a4-card-head">Teks Berjalan <span style="font-size:12px;font-weight:400;color:#64748b">— satu baris = satu item</span></div>
        <form method="post"><?php wp_nonce_field('a4_ticker','_n'); ?>
        <div class="a4-field u-mb-lg">
            <textarea name="ticker" rows="10" style="font-family:monospace;font-size:12px"><?php echo esc_textarea(implode("\n",$t)); ?></textarea>
        </div>
        <button type="submit" class="a4-btn-primary">💾 Simpan Ticker</button>
        </form>
    </div>
    </div>
    <?php
}

/* ═══ 5. RUNDOWN ════════════════════════════════════════ */
function assie4_admin_rundown() {
    if ( ! current_user_can('manage_options') ) return;
    if ( isset($_POST['_n']) && wp_verify_nonce($_POST['_n'],'a4_rundown') ) {
        $days = array_map( fn($l) => ['label'=>sanitize_text_field($l)], ($_POST['dl']??[]) );
        $evs  = [];
        foreach ( ($_POST['en']??[]) as $i => $name ) {
            if (!trim($name)) continue;
            $evs[] = ['day'=>intval($_POST['ed'][$i]??0),'time'=>sanitize_text_field($_POST['et'][$i]??''),'end'=>sanitize_text_field($_POST['ee'][$i]??''),'name'=>sanitize_text_field($name),'type'=>sanitize_text_field($_POST['ety'][$i]??'keynote'),'loc'=>sanitize_text_field($_POST['el'][$i]??'')];
        }
        usort( $evs, fn($a,$b) => $a['day']<=>$b['day'] ?: strcmp($a['time'],$b['time']) );
        update_option( ASSIE4_OPT_RUNDOWN, ['days'=>$days,'events'=>$evs] );
        assie4_rebuild_js_data();
        a4_notice('✅ Rundown disimpan!');
    }
    $rd   = get_option( ASSIE4_OPT_RUNDOWN, assie4_default_rundown() );
    $days = $rd['days']   ?? [];
    $evs  = $rd['events'] ?? [];
    $types = ['keynote'=>'Keynote','panel'=>'Panel','workshop'=>'Workshop','networking'=>'Hiburan','break'=>'Break','award'=>'Penutupan'];
    a4_header('Rundown Acara', count($evs).' event');
    ?>
    <form method="post"><?php wp_nonce_field('a4_rundown','_n'); ?>
    <div class="a4-card">
        <div class="a4-card-head">Label Hari</div>
        <div class="a4-row a4-row-3">
        <?php foreach ($days as $i => $d) : ?>
            <div class="a4-field"><label>Hari <?php echo $i+1 ?></label><input name="dl[]" value="<?php echo esc_attr($d['label']); ?>"></div>
        <?php endforeach; ?>
        </div>
    </div>
    <div class="a4-card">
        <div class="a4-card-head">Daftar Event</div>
        <div id="a4EW">
        <?php foreach ($evs as $e) : ?>
        <div class="a4-item-box">
            <div class="a4-item-header">
                <span class="a4-item-num">Hari <?php echo $e['day']+1 ?> · <?php echo esc_html($e['time']) ?></span>
                <button type="button" class="a4-btn-del" onclick="this.closest('.a4-item-box').remove()">✕</button>
            </div>
            <div class="a4-row a4-row-3">
                <div class="a4-field"><label>Hari</label><select name="ed[]"><?php for($d=0;$d<count($days);$d++) echo '<option value="'.$d.'"'.($e['day']==$d?' selected':'').'>Hari '.($d+1).'</option>'; ?></select></div>
                <div class="a4-field"><label>Mulai</label><input name="et[]" value="<?php echo esc_attr($e['time']); ?>"></div>
                <div class="a4-field"><label>Selesai</label><input name="ee[]" value="<?php echo esc_attr($e['end']); ?>"></div>
            </div>
            <div class="a4-row">
                <div class="a4-field"><label>Nama Event</label><input name="en[]" value="<?php echo esc_attr($e['name']); ?>"></div>
                <div class="a4-field"><label>Tipe</label><select name="ety[]"><?php foreach($types as $k=>$v) echo '<option value="'.$k.'"'.($e['type']===$k?' selected':'').'>'.$v.'</option>'; ?></select></div>
            </div>
            <div class="a4-field"><label>Lokasi</label><input name="el[]" value="<?php echo esc_attr($e['loc']); ?>"></div>
        </div>
        <?php endforeach; ?>
        </div>
        <button type="button" class="a4-btn-add" onclick="a4AE()">＋ Tambah Event</button>
    </div>
    <button type="submit" class="a4-btn-primary">💾 Simpan Rundown</button>
    </form>
    </div>
    <script>
    var a4DC=<?php echo count($days); ?>;
    function a4AE(){var o='',t='<option value="keynote">Keynote</option><option value="panel">Panel</option><option value="workshop">Workshop</option><option value="networking">Hiburan</option><option value="break">Break</option><option value="award">Penutupan</option>';for(var i=0;i<a4DC;i++) o+='<option value="'+i+'">Hari '+(i+1)+'</option>';document.getElementById('a4EW').insertAdjacentHTML('beforeend','<div class="a4-item-box"><div class="a4-item-header"><span class="a4-item-num">Event Baru</span><button type="button" class="a4-btn-del" onclick="this.closest(\'.a4-item-box\').remove()">✕</button></div><div class="a4-row a4-row-3"><div class="a4-field"><label>Hari</label><select name="ed[]">'+o+'</select></div><div class="a4-field"><label>Mulai</label><input name="et[]" value="08.00"></div><div class="a4-field"><label>Selesai</label><input name="ee[]" value="09.00"></div></div><div class="a4-row"><div class="a4-field"><label>Nama</label><input name="en[]" value=""></div><div class="a4-field"><label>Tipe</label><select name="ety[]">'+t+'</select></div></div><div class="a4-field"><label>Lokasi</label><input name="el[]" value="Main Stage"></div></div>');}
    </script>
    <?php
}

/* ═══ 6. KELOLA TENANT ══════════════════════════════════ */
function assie4_admin_tenants() {
    if ( ! current_user_can('manage_options') ) return;

    $page_url = admin_url('admin.php?page=assie4-tenants');

    /* Hapus tenant */
    if ( isset($_GET['del_t'], $_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'del_t_'.$_GET['del_t']) ) {
        $del_id  = sanitize_text_field($_GET['del_t']);
        $tenants = assie4_get_tenants();
        $tenants = array_values( array_filter($tenants, fn($t) => $t['id'] !== $del_id) );
        assie4_save_tenants($tenants);
        a4_notice('✅ Tenant '.esc_html($del_id).' dihapus. Halaman pameran terupdate.');
    }

    /* Simpan (tambah/edit) */
    if ( isset($_POST['_nt']) && wp_verify_nonce($_POST['_nt'], 'a4_tenant') ) {
        $edit_id = sanitize_text_field($_POST['original_id'] ?? '');
        $new_id  = strtoupper(sanitize_text_field($_POST['t_id'] ?? ''));
        if ( empty($new_id) ) {
            a4_notice('❌ Kode Booth tidak boleh kosong.','err');
        } else {
            $tags = array_values( array_filter( array_map('trim', explode(',', sanitize_text_field($_POST['t_tags']??''))) ) );
            $new_tenant = assie4_normalize_tenant([
                'id'        => strtolower($new_id),
                'booth_no'  => intval($_POST['t_booth_no'] ?? 0),
                'code'      => $new_id,
                'cluster'   => intval($_POST['t_cluster'] ?? 0),
                'area'      => strtoupper(sanitize_text_field($_POST['t_area']      ?? 'A')),
                'name'      => sanitize_text_field($_POST['t_name']      ?? ''),
                'instansi'  => sanitize_text_field($_POST['t_instansi']  ?? ''),
                'pic'       => sanitize_text_field($_POST['t_pic']       ?? ''),
                'cat'       => sanitize_text_field($_POST['t_cat']       ?? ''),
                'desc'      => sanitize_textarea_field($_POST['t_desc']  ?? ''),
                'tags'      => $tags,
                'logo'      => esc_url_raw($_POST['t_logo']              ?? ''),
                'contact'   => sanitize_text_field($_POST['t_contact']   ?? ''),
                'whatsapp'  => sanitize_text_field($_POST['t_whatsapp']  ?? ''),
                'web'       => esc_url_raw($_POST['t_web']               ?? ''),
                'instagram' => sanitize_text_field($_POST['t_instagram'] ?? ''),
                'facebook'  => esc_url_raw($_POST['t_facebook']          ?? ''),
                'twitter'   => sanitize_text_field($_POST['t_twitter']   ?? ''),
                'transaksi' => sanitize_text_field($_POST['t_transaksi'] ?? ''),
            ]);
            $tenants = assie4_get_tenants();
            if ( $edit_id ) {
                $found = false;
                foreach ($tenants as $k => $t) { if ($t['id']===$edit_id){$tenants[$k]=$new_tenant;$found=true;break;} }
                if (!$found) $tenants[] = $new_tenant;
            } else {
                if ( in_array($new_id, array_column($tenants,'id'), true) ) {
                    a4_notice('❌ Kode Booth "'.$new_id.'" sudah ada.','err');
                    $new_tenant = null;
                } else {
                    $tenants[] = $new_tenant;
                }
            }
            if ( isset($new_tenant) && $new_tenant ) {
                assie4_save_tenants($tenants);
                $mode = $edit_id ? 'diupdate' : 'ditambahkan';
                a4_notice('✅ Tenant '.$new_id.' berhasil '.$mode.'! Halaman pameran sudah terupdate.');
                echo '<script>setTimeout(function(){window.location.href="'.esc_url($page_url).'"},1200);</script>';
            }
        }
    }

    $tenants   = assie4_get_tenants();
    $editId    = $_GET['edit'] ?? null;
    $fa        = $_GET['fa']   ?? 'all';
    $search    = strtolower(trim($_GET['s'] ?? ''));
    $apc       = ['A'=>'ap-A','B'=>'ap-B','C'=>'ap-C','D'=>'ap-D','E'=>'ap-E','F'=>'ap-F','G'=>'ap-G','H'=>'ap-H'];

    a4_header('Kelola Tenant', count($tenants).' tenant');

    // Preview bar
    $p = get_page_by_path(ASSIE4_PAMERAN_SLUG);
    if ($p) echo '<div class="a4-preview-bar">✅ Perubahan tenant <strong>langsung tampil</strong> di <a href="'.esc_url(get_permalink($p)).'" target="_blank">halaman pameran</a>.</div>';

    /* Form tambah / edit */
    if ( $editId !== null ) {
        $t      = null;
        $is_new = ($editId === 'new');
        if ( !$is_new ) { foreach ($tenants as $item) { if ($item['id']===$editId){$t=$item;break;} } }
        if ( !$t ) $t = assie4_normalize_tenant([]);
        ?>
        <div class="a4-card">
        <div class="a4-card-head"><?php echo $is_new ? '➕ Tambah Tenant Baru' : '✏️ Edit Tenant — '.esc_html($editId); ?></div>
        <form method="post" action="<?php echo esc_url($page_url); ?>">
            <?php wp_nonce_field('a4_tenant','_nt'); ?>
            <input type="hidden" name="original_id" value="<?php echo $is_new ? '' : esc_attr($editId); ?>">

            <span class="a4-sect">📋 Identitas Booth & Perusahaan</span>
            <div class="a4-row a4-row-3">
                <div class="a4-field"><label>1. Kode Booth (Plot)</label><input name="t_id" value="<?php echo esc_attr($t['code'] ?: $t['id']); ?>" placeholder="mis: A1, B3, F2" required></div>
                <div class="a4-field"><label>2. No. Booth Denah (1–106)</label><input type="number" name="t_booth_no" value="<?php echo esc_attr($t['booth_no'] ?: ''); ?>" placeholder="mis: 99, 52" min="1" max="106"></div>
                <div class="a4-field"><label>3. Area</label>
                    <select name="t_area">
                        <?php 
                        $area_labels = [
                            'A'=>'Area A — UNAIR',
                            'B'=>'Area B — Riset & Unit',
                            'C'=>'Area C — Sponsorship',
                            'D'=>'Area D — Startup & Mitra',
                            'E'=>'Area E — Inkubasi Bisnis',
                            'F'=>'Area F — Startup Inovasi',
                            'G'=>'Area G — Kuliner & Bisnis',
                            'H'=>'Area H — Craft & Fashion'
                        ];
                        foreach ($area_labels as $ar=>$lbl)
                            echo '<option value="'.$ar.'"'.($t['area']===$ar?' selected':'').'>'.esc_html($lbl).'</option>'; ?>
                    </select>
                </div>
            </div>
            <div class="a4-row">
                <div class="a4-field"><label>4. Nama Tenant / Brand</label><input name="t_name" value="<?php echo esc_attr($t['name']); ?>" placeholder="Nama booth atau brand" required></div>
                <div class="a4-field"><label>5. Badan Usaha / PT / CV / Instansi</label><input name="t_instansi" value="<?php echo esc_attr($t['instansi']); ?>" placeholder="mis: PT Jobhun Membangun Indonesia"></div>
            </div>
            <div class="a4-row a4-row-3">
                <div class="a4-field"><label>6. Kategori</label><input name="t_cat" value="<?php echo esc_attr($t['cat']); ?>" placeholder="mis: Startup, Riset, Craft"></div>
                <div class="a4-field"><label>7. Nama PIC</label><input name="t_pic" value="<?php echo esc_attr($t['pic']); ?>" placeholder="Nama penanggung jawab"></div>
                <div class="a4-field"><label>8. Transaksi di Booth</label>
                    <select name="t_transaksi">
                        <option value="Ya"<?php echo ($t['transaksi']==='Ya'?' selected':''); ?>>Ya (Ada Transaksi)</option>
                        <option value="Tidak"<?php echo ($t['transaksi']==='Tidak'?' selected':''); ?>>Tidak</option>
                    </select>
                </div>
            </div>
            <div class="a4-field u-mb-md"><label>9. Deskripsi Singkat</label><textarea name="t_desc" rows="3" placeholder="Deskripsi tentang tenant / produk ini…"><?php echo esc_textarea($t['desc']); ?></textarea></div>
            <div class="a4-row">
                <div class="a4-field"><label>10. Tags <small>(pisah koma)</small></label><input name="t_tags" value="<?php echo esc_attr(implode(', ',$t['tags'])); ?>" placeholder="Startup, Teknologi, Inovasi"></div>
                <div class="a4-field"><label>11. Logo <small>(URL gambar langsung atau Drive thumbnail)</small></label><input type="url" name="t_logo" value="<?php echo esc_attr($t['logo']); ?>" placeholder="https://..."></div>
            </div>

            <span class="a4-sect">📱 Kontak & Media Sosial</span>
            <div class="a4-row">
                <div class="a4-field"><label>12. Email Kontak</label><input type="text" name="t_contact" value="<?php echo esc_attr($t['contact']); ?>" placeholder="email@domain.com"></div>
                <div class="a4-field"><label>13. WhatsApp / HP</label><input type="text" name="t_whatsapp" value="<?php echo esc_attr($t['whatsapp']); ?>" placeholder="mis: 08123456789"></div>
                <div class="a4-field"><label>14. Website / URL</label><input type="url" name="t_web" value="<?php echo esc_attr($t['web']); ?>" placeholder="https://..."></div>
            </div>
            <div class="a4-row a4-row-3">
                <div class="a4-field"><label>15. Instagram</label><input name="t_instagram" value="<?php echo esc_attr($t['instagram']); ?>" placeholder="@namaakun"></div>
                <div class="a4-field"><label>16. Facebook</label><input name="t_facebook" value="<?php echo esc_attr($t['facebook']); ?>" placeholder="https://facebook.com/..."></div>
                <div class="a4-field"><label>17. X / Twitter</label><input name="t_twitter" value="<?php echo esc_attr($t['twitter']); ?>" placeholder="@namaakun"></div>
            </div>

            <div class="u-flex u-items-center u-gap-md" style="margin-top:20px;padding-top:16px;border-top:1px solid #e5e7eb">
                <button type="submit" class="a4-btn-primary"><?php echo $is_new ? '➕ Tambah Tenant' : '💾 Simpan Perubahan'; ?></button>
                <a href="<?php echo esc_url($page_url); ?>" class="u-text-light u-text-xs u-text-semibold" style="text-decoration:none">← Batal</a>
            </div>
        </form>
        </div>
        <?php
    }

    /* Tabel daftar tenant */
    $filtered = array_filter($tenants, function($t) use($fa,$search){
        return ($fa==='all'||$t['area']===$fa) && (!$search || stripos($t['id'].$t['name'].$t['cat'],$search)!==false);
    });
    ?>
    <div class="a4-card">
        <div class="a4-card-head">
            <span>Daftar Tenant (<?php echo count($filtered); ?>/<?php echo count($tenants); ?>)</span>
            <a href="<?php echo esc_url(add_query_arg('edit','new',$page_url)); ?>" class="a4-btn-gold" style="font-size:12px;padding:7px 16px;margin-top:0">＋ Tambah Tenant</a>
        </div>
        <div class="a4-filter-bar">
            <form method="get" id="a4SF" style="display:contents">
                <input type="hidden" name="page" value="assie4-tenants">
                <select name="fa" onchange="this.form.submit()">
                    <option value="all">Semua Area</option>
                    <?php foreach (['A'=>'Area A — UNAIR','B'=>'Area B — Riset & Unit','C'=>'Area C — Sponsor','D'=>'Area D — Startup','E'=>'Area E — Inkubasi','F'=>'Area F — Inovasi','G'=>'Area G — Kuliner','H'=>'Area H — Craft'] as $ar=>$lbl)
                        echo '<option value="'.$ar.'"'.($fa===$ar?' selected':'').'>'.esc_html($lbl).'</option>'; ?>
                </select>
                <input type="text" name="s" id="a4SI" value="<?php echo esc_attr($search); ?>" placeholder="Cari kode / nama…"
                       onkeyup="clearTimeout(window._a4t);window._a4t=setTimeout(function(){document.getElementById('a4SF').submit()},500)">
            </form>
        </div>
        <?php if ( empty($filtered) ) : ?>
        <div class="a4-empty-state">
            <span class="a4-es-ico">🏪</span>
            <h3><?php echo count($tenants)===0 ? 'Belum ada tenant' : 'Tidak ditemukan'; ?></h3>
            <p><?php echo count($tenants)===0 ? 'Mulai tambahkan tenant pertama untuk ditampilkan di halaman pameran.' : 'Ubah filter atau kata kunci.'; ?></p>
            <?php if (count($tenants)===0) : ?>
            <a href="<?php echo esc_url(add_query_arg('edit','new',$page_url)); ?>" class="a4-btn-gold">➕ Tambah Tenant Pertama</a>
            <?php endif; ?>
        </div>
        <?php else : ?>
        <table class="a4-table">
            <thead><tr><th>No Denah</th><th>Kode</th><th>Area</th><th>Nama Tenant / Brand</th><th>Instansi / PT / CV</th><th>Kategori</th><th>Sosmed</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php foreach ($filtered as $t) :
                $eu = esc_url(add_query_arg('edit', urlencode($t['id']), $page_url));
                $du = esc_url(wp_nonce_url(add_query_arg(['del_t'=>$t['id']],$page_url),'del_t_'.$t['id']));
            ?>
            <tr>
                <td><strong style="color:#d4a843"><?php echo esc_html($t['booth_no'] ?: '—'); ?></strong></td>
                <td><strong><?php echo esc_html($t['code'] ?: strtoupper($t['id'])); ?></strong></td>
                <td><span class="a4-ap <?php echo $apc[$t['area']]??''; ?>"><?php echo esc_html($t['area']); ?></span></td>
                <td>
                    <?php if($t['logo']) : ?><img src="<?php echo esc_url($t['logo']); ?>" style="height:20px;margin-right:6px;vertical-align:middle;border-radius:3px" onerror="this.remove()"><?php endif; ?>
                    <strong><?php echo esc_html($t['name']); ?></strong>
                    <?php if($t['desc']) : ?><div style="font-size:11px;color:#94a3b8;margin-top:2px"><?php echo esc_html(mb_strimwidth($t['desc'],0,55,'…')); ?></div><?php endif; ?>
                </td>
                <td style="font-size:12px;color:#93c5fd"><?php echo esc_html($t['instansi'] ?: '—'); ?></td>
                <td style="font-size:12px;color:#64748b"><?php echo esc_html($t['cat']); ?></td>
                <td class="a4-ic">
                    <?php if($t['contact']) echo '<a href="mailto:'.esc_attr($t['contact']).'" title="'.esc_attr($t['contact']).'">📧</a>'; ?>
                    <?php if($t['web'])     echo '<a href="'.esc_url($t['web']).'" target="_blank" title="'.esc_attr($t['web']).'">🌐</a>'; ?>
                    <?php if($t['instagram']){$u=strpos($t['instagram'],'http')===0?$t['instagram']:'https://instagram.com/'.ltrim($t['instagram'],'@');echo '<a href="'.esc_url($u).'" target="_blank">📷</a>';}?>
                    <?php if($t['facebook'])echo '<a href="'.esc_url($t['facebook']).'" target="_blank">👍</a>'; ?>
                    <?php if($t['twitter']){$u=strpos($t['twitter'],'http')===0?$t['twitter']:'https://x.com/'.ltrim($t['twitter'],'@');echo '<a href="'.esc_url($u).'" target="_blank">🐦</a>';}?>
                </td>
                <td style="white-space:nowrap">
                    <a href="<?php echo $eu; ?>" style="font-size:12px;font-weight:700;color:#1e40af;text-decoration:none;margin-right:8px">✏️ Edit</a>
                    <a href="<?php echo $du; ?>" onclick="return confirm('Hapus <?php echo esc_js($t['id'].': '.$t['name']); ?>?')" style="font-size:12px;font-weight:700;color:#dc2626;text-decoration:none">✕ Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
    </div>
    <?php
}

/* ═══ 7. DENAH & GALERI ═════════════════════════════════ */
function assie4_admin_denah() {
    if ( ! current_user_can('manage_options') ) return;
    if ( isset($_POST['_nd']) && wp_verify_nonce($_POST['_nd'],'a4_denah') ) {
        if ( isset($_POST['d_base_reset']) ) {
            delete_option('assie4_pameran_denah_base_image');
        } else {
            update_option('assie4_pameran_denah_base_image', esc_url_raw(trim($_POST['d_base_url'] ?? '')));
        }
        $imgs = [];
        foreach ( ($_POST['d_url']??[]) as $i => $url ) {
            $url = esc_url_raw(trim($url));
            if (!$url) continue;
            $imgs[] = ['url'=>$url,'caption'=>sanitize_text_field($_POST['d_cap'][$i]??'')];
        }
        update_option('assie4_pameran_denah', $imgs);
        assie4_rebuild_js_data();
        a4_notice(isset($_POST['d_base_reset']) ? '✅ Denah kembali memakai gambar bawaan plugin.' : '✅ Gambar denah disimpan! Halaman pameran terupdate.');
    }
    $imgs = get_option('assie4_pameran_denah', []);
    $base_url = get_option('assie4_pameran_denah_base_image', '');
    $default_url = ASSIE4_PAMERAN_URL . 'assets/denah-assie-iv-reference.png';
    a4_header('Denah & Galeri Foto', count($imgs).' gambar');
    ?>
    <div class="a4-card">
        <div class="a4-card-head">Denah Interaktif Utama</div>
        <p class="u-text-sm u-text-muted u-mb-md">Denah bawaan memakai referensi venue ASSIE IV dari plugin. Anda dapat memilih gambar baru dari Media Library; posisi hotspot booth tetap mengikuti denah referensi.</p>
        <form method="post"><?php wp_nonce_field('a4_denah','_nd'); ?>
            <div class="a4-denah-preview" id="a4BasePreview" style="margin-bottom:12px">
                <img src="<?php echo esc_url($base_url ?: $default_url); ?>" style="max-width:100%;max-height:260px;border-radius:6px;object-fit:contain" alt="Preview denah interaktif">
            </div>
            <div class="a4-field" style="margin-bottom:10px"><label>URL Gambar Override</label><input type="url" name="d_base_url" id="a4BaseUrl" value="<?php echo esc_attr($base_url); ?>" placeholder="Kosongkan untuk menggunakan gambar bawaan"></div>
            <div class="u-flex u-gap-sm">
                <button type="button" class="a4-btn-gold u-text-xs u-whitespace-nowrap" style="padding:7px 14px;background:#0073aa" onclick="a4PickBase()">📁 Pilih dari Media</button>
                <button type="submit" class="a4-btn-primary">💾 Simpan Denah Utama</button>
                <button type="submit" class="a4-btn-del" name="d_base_reset" value="1">↺ Reset ke bawaan</button>
            </div>
        </form>
    </div>
    <div class="a4-card">
        <div class="a4-card-head">Upload Gambar Denah</div>
        <p class="u-text-sm u-text-muted u-mb-md">Gambar ditampilkan di bawah denah interaktif di halaman pameran. Klik untuk perbesar (lightbox). Gunakan tombol <strong>📁 Pilih dari Media</strong> untuk upload dari Library WordPress.</p>
        <form method="post"><?php wp_nonce_field('a4_denah','_nd'); ?>
        <div id="a4DW">
        <?php if (empty($imgs)) : ?>
        <div class="a4-item-box" id="a4di_0">
            <div class="a4-denah-preview" id="a4dp_0"><span style="color:#94a3b8;font-size:13px">📷 Belum ada gambar</span></div>
            <div class="a4-row" style="margin-top:10px">
                <div class="a4-field"><label>URL Gambar</label><input type="url" name="d_url[]" id="a4du_0" placeholder="https://..." onchange="a4PrevImg(0)"></div>
                <div class="a4-field"><label>Keterangan (opsional)</label><input type="text" name="d_cap[]" placeholder="mis: Denah Lantai 1"></div>
            </div>
            <div class="u-flex u-gap-sm" style="margin-top:8px">
                <button type="button" class="a4-btn-gold u-text-xs u-whitespace-nowrap" style="padding:7px 14px;background:#0073aa" onclick="a4Pick(0)">📁 Pilih dari Media</button>
                <button type="button" class="a4-btn-del" onclick="this.closest('.a4-item-box').remove()">✕ Hapus</button>
            </div>
        </div>
        <?php else : foreach ($imgs as $i => $img) : ?>
        <div class="a4-item-box" id="a4di_<?php echo $i; ?>">
            <div class="a4-denah-preview" id="a4dp_<?php echo $i; ?>">
                <?php if ($img['url']) : ?><img src="<?php echo esc_url($img['url']); ?>" style="max-width:100%;max-height:180px;border-radius:6px;object-fit:contain">
                <?php else : ?><span style="color:#94a3b8;font-size:13px">📷 Belum ada gambar</span><?php endif; ?>
            </div>
            <div class="a4-row" style="margin-top:10px">
                <div class="a4-field"><label>URL Gambar</label><input type="url" name="d_url[]" id="a4du_<?php echo $i; ?>" value="<?php echo esc_attr($img['url']); ?>" placeholder="https://..." onchange="a4PrevImg(<?php echo $i; ?>)"></div>
                <div class="a4-field"><label>Keterangan</label><input type="text" name="d_cap[]" value="<?php echo esc_attr($img['caption']??''); ?>"></div>
            </div>
            <div class="u-flex u-gap-sm" style="margin-top:8px">
                <button type="button" class="a4-btn-gold u-text-xs u-whitespace-nowrap" style="padding:7px 14px;background:#0073aa" onclick="a4Pick(<?php echo $i; ?>)">📁 Pilih dari Media</button>
                <button type="button" class="a4-btn-del" onclick="this.closest('.a4-item-box').remove()">✕ Hapus</button>
            </div>
        </div>
        <?php endforeach; endif; ?>
        </div>
        <div class="u-flex u-gap-md u-mb-lg">
            <button type="button" class="a4-btn-add" onclick="a4AddImg()">＋ Tambah Gambar</button>
            <button type="submit" class="a4-btn-primary">💾 Simpan Semua Gambar</button>
        </div>
        </form>
    </div>
    </div>
    <script>
    var a4DI=<?php echo max(count($imgs),1); ?>,a4MF=null,a4MT=null;
    function a4PrevImg(i){var u=document.getElementById('a4du_'+i).value,p=document.getElementById('a4dp_'+i);p.innerHTML=u?'<img src="'+u+'" style="max-width:100%;max-height:180px;border-radius:6px;object-fit:contain" onerror="this.parentNode.innerHTML=\'<span style=color:#94a3b8>❌ URL tidak valid</span>\'">':'<span style="color:#94a3b8;font-size:13px">📷 Belum ada gambar</span>';}
    function a4AddImg(){var i=a4DI++;document.getElementById('a4DW').insertAdjacentHTML('beforeend','<div class="a4-item-box" id="a4di_'+i+'"><div class="a4-denah-preview" id="a4dp_'+i+'"><span style="color:#94a3b8;font-size:13px">📷 Belum ada gambar</span></div><div class="a4-row" style="margin-top:10px"><div class="a4-field"><label>URL Gambar</label><input type="url" name="d_url[]" id="a4du_'+i+'" placeholder="https://..." onchange="a4PrevImg('+i+')"></div><div class="a4-field"><label>Keterangan</label><input type="text" name="d_cap[]"></div></div><div style="margin-top:8px;display:flex;gap:8px"><button type="button" class="a4-btn-gold" style="font-size:12px;padding:7px 14px;margin-top:0;background:#0073aa" onclick="a4Pick('+i+')">📁 Pilih dari Media</button><button type="button" class="a4-btn-del" onclick="this.closest(\'.a4-item-box\').remove()">✕</button></div></div>');}
    function a4Pick(i){a4MT=i;if(a4MF){a4MF.open();return;}a4MF=wp.media({title:'Pilih Gambar Denah',button:{text:'Gunakan Gambar'},multiple:false,library:{type:'image'}});a4MF.on('select',function(){var att=a4MF.state().get('selection').first().toJSON();document.getElementById('a4du_'+a4MT).value=att.url||'';a4PrevImg(a4MT);});a4MF.open();}
    function a4PickBase(){var frame=wp.media({title:'Pilih Denah Interaktif',button:{text:'Gunakan sebagai denah utama'},multiple:false,library:{type:'image'}});frame.on('select',function(){var att=frame.state().get('selection').first().toJSON(),url=att.url||'';document.getElementById('a4BaseUrl').value=url;document.getElementById('a4BasePreview').innerHTML='<img src="'+url+'" style="max-width:100%;max-height:260px;border-radius:6px;object-fit:contain" alt="Preview denah interaktif">';});frame.open();}
    </script>
    <?php
}

/* ═══ 8. BOOTH PASINBIS ═════════════════════════════════ */
function assie4_admin_pasinbis() {
    if ( ! current_user_can('manage_options') ) return;
    if ( isset($_POST['_np']) && wp_verify_nonce($_POST['_np'],'a4_pasinbis') ) {
        update_option('assie4_pasinbis_url',  esc_url_raw($_POST['pasinbis_url']  ?? ''));
        update_option('assie4_pasinbis_nama', sanitize_text_field($_POST['pasinbis_nama'] ?? ''));
        update_option('assie4_pasinbis_desk', sanitize_textarea_field($_POST['pasinbis_desk'] ?? ''));
        update_option('assie4_pasinbis_logo', esc_url_raw($_POST['pasinbis_logo'] ?? ''));
        update_option('assie4_pasinbis_ig',   sanitize_text_field($_POST['pasinbis_ig']   ?? ''));
        update_option('assie4_pasinbis_web',  esc_url_raw($_POST['pasinbis_web']  ?? ''));
        assie4_rebuild_js_data();
        a4_notice('✅ Informasi Booth PASINBIS disimpan!');
    }
    a4_header('Booth PASINBIS', 'Pengaturan');
    ?>
    <div class="a4-card">
        <div class="a4-card-head">Informasi Booth PASINBIS</div>
        <p style="font-size:13px;color:#64748b;margin-bottom:16px">Booth PASINBIS tampil di denah dengan border emas, terpisah dari area A–E. Klik di halaman pameran membuka URL di bawah ini. Data ini juga tampil di modal popup saat diklik.</p>
        <form method="post"><?php wp_nonce_field('a4_pasinbis','_np'); ?>
        <div class="a4-row">
            <div class="a4-field"><label>Nama Booth</label><input name="pasinbis_nama" value="<?php echo esc_attr(get_option('assie4_pasinbis_nama','PASINBIS UNAIR')); ?>" placeholder="PASINBIS Universitas Airlangga"></div>
            <div class="a4-field"><label>URL Klik di Denah</label><input type="url" name="pasinbis_url" value="<?php echo esc_attr(get_option('assie4_pasinbis_url','https://pasinbis.unair.ac.id')); ?>" placeholder="https://pasinbis.unair.ac.id"></div>
        </div>
        <div class="a4-field u-mb-md"><label>Deskripsi Singkat</label><textarea name="pasinbis_desk" rows="2"><?php echo esc_textarea(get_option('assie4_pasinbis_desk','Pusat Akselerasi Inovasi dan Bisnis Universitas Airlangga')); ?></textarea></div>
        <div class="a4-row">
            <div class="a4-field"><label>URL Logo</label><input type="url" name="pasinbis_logo" value="<?php echo esc_attr(get_option('assie4_pasinbis_logo','')); ?>" placeholder="https://..."></div>
            <div class="a4-field"><label>Instagram</label><input name="pasinbis_ig" value="<?php echo esc_attr(get_option('assie4_pasinbis_ig','@paib_unair')); ?>" placeholder="@paib_unair"></div>
        </div>
        <div class="a4-field u-mb-lg"><label>Website / TokoUA</label><input type="url" name="pasinbis_web" value="<?php echo esc_attr(get_option('assie4_pasinbis_web','https://tokoua.unair.ac.id')); ?>" placeholder="https://tokoua.unair.ac.id"></div>
        <button type="submit" class="a4-btn-primary">💾 Simpan Booth PASINBIS</button>
        </form>
    </div>
    <div class="a4-card" style="background:#fffbeb;border-color:#fde68a">
        <div class="a4-card-head" style="border-color:#f59e0b">Preview di Denah</div>
        <p class="u-text-sm" style="color:#92400e">Booth PASINBIS tampil dengan warna emas (border #d4a843) dan label nama yang diisi di atas. Sub-label menggunakan deskripsi singkat (28 karakter pertama). Klik → buka URL di tab baru.</p>
    </div>
    </div>
    <?php
}

/* ═══ 9. EXPORT / RESET ═════════════════════════════════ */
function assie4_admin_export() {
    if ( ! current_user_can('manage_options') ) return;
    if ( isset($_GET['a4_reload_official'], $_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'a4_reload_official') ) {
        update_option( ASSIE4_OPT_TENANTS, assie4_default_tenants(), false );
        update_option( 'assie4_directory_seed_state', 'v4', false );
        assie4_rebuild_js_data();
        a4_notice('✅ Berhasil memuat ulang 79 data tenant resmi dari Excel ASSIE IV 2026!');
    }
    if ( isset($_POST['_nr']) && wp_verify_nonce($_POST['_nr'],'a4_reset') ) {
        if (isset($_POST['ri'])) { delete_option(ASSIE4_OPT_INFO);    a4_notice('✅ Info acara direset ke default.'); }
        if (isset($_POST['rs'])) { delete_option(ASSIE4_OPT_SLIDES);  a4_notice('✅ Slides direset ke default.'); }
        if (isset($_POST['rk'])) { delete_option(ASSIE4_OPT_TICKER);  a4_notice('✅ Ticker direset ke default.'); }
        if (isset($_POST['rr'])) { delete_option(ASSIE4_OPT_RUNDOWN); a4_notice('✅ Rundown direset ke default.'); }
        if (isset($_POST['rt'])) {
            delete_option(ASSIE4_OPT_TENANTS);
            delete_option('assie4_tenants_seeded');
            delete_option('assie4_seed_ver');
            update_option('assie4_pameran_tenants', [], false);
            update_option('assie4_directory_seed_state', 'v3', false);
            a4_notice('✅ Semua tenant dihapus. Tambahkan tenant baru dari menu Kelola Tenant.');
        }
        if (isset($_POST['rn'])) {
            delete_transient('assie4_news_cache');
            a4_notice('✅ Cache berita dihapus. Berita akan di-refresh saat halaman pameran dibuka.');
        }
        assie4_rebuild_js_data();
    }
    a4_header('Export & Reset');
    ?>
        <div class="a4-card">
        <div class="a4-card-head">🔄 Muat Ulang Data Resmi Excel ASSIE IV 2026</div>
        <p class="u-text-sm u-text-light u-mb-md">Muat ulang seluruh 79 data tenant resmi dari file Excel Ploting Booth & Formulir Kesediaan Peserta ASSIE IV 2026 (termasuk deskripsi, logo, medsos, dan identitas PT/CV).</p>
        <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=assie4-export&a4_reload_official=1'),'a4_reload_official')); ?>" class="a4-btn-gold" onclick="return confirm('Muat ulang 79 data tenant resmi dari Excel?')">🔄 Muat Ulang Data Resmi (79 Tenant)</a>
    </div>
    <div class="a4-card">
        <div class="a4-card-head">Export Backup JSON</div>
        <p class="u-text-sm u-text-light u-mb-md">Download semua data plugin (info, slides, ticker, rundown, tenant, denah) dalam format JSON.</p>
        <a href="<?php echo esc_url(admin_url('admin-ajax.php?action=assie4_export&_wpnonce='.wp_create_nonce('a4_export'))); ?>" class="a4-btn-primary">⬇️ Download Backup JSON</a>
    </div>
    <div class="a4-card" style="border-color:#fecaca">
        <div class="a4-card-head" style="color:#dc2626;border-color:#f87171">⚠️ Reset Data</div>
        <p class="u-text-sm u-text-light u-mb-lg">Data yang direset <strong>tidak dapat dikembalikan</strong>. Pastikan sudah backup dulu.</p>
        <form method="post" onsubmit="return confirm('Yakin ingin mereset data yang dipilih?')">
            <?php wp_nonce_field('a4_reset','_nr'); ?>
            <div class="u-flex u-flex-col u-gap-md u-mb-lg u-text-sm">
                <label><input type="checkbox" name="ri"> Reset Info Acara ke default</label>
                <label><input type="checkbox" name="rs"> Reset Hero Slides ke default</label>
                <label><input type="checkbox" name="rk"> Reset Ticker ke default</label>
                <label><input type="checkbox" name="rr"> Reset Rundown ke default</label>
                <label class="u-text-bold" style="color:#dc2626"><input type="checkbox" name="rt"> 🗑 HAPUS SEMUA TENANT (database dikosongkan)</label>
                <label><input type="checkbox" name="rn"> 🔄 Hapus cache berita (refresh dari pasinbis)</label>
            </div>
            <button type="submit" class="a4-btn-danger">Lakukan Reset</button>
        </form>
    </div>
    </div>
    <?php
}

/* ═══ AJAX ══════════════════════════════════════════════ */
add_action('wp_ajax_assie4_export', function() {
    if (!current_user_can('manage_options')||!wp_verify_nonce($_GET['_wpnonce']??'','a4_export')) wp_die('Unauthorized');
    header('Content-Type: application/json; charset=utf-8');
    header('Content-Disposition: attachment; filename="assie4-backup-'.date('Y-m-d').'.json"');
    echo wp_json_encode([
        'exported_at' => date('Y-m-d H:i:s'),
        'info'        => get_option(ASSIE4_OPT_INFO,    assie4_default_info()),
        'slides'      => get_option(ASSIE4_OPT_SLIDES,  assie4_default_slides()),
        'ticker'      => get_option(ASSIE4_OPT_TICKER,  assie4_default_ticker()),
        'rundown'     => get_option(ASSIE4_OPT_RUNDOWN, assie4_default_rundown()),
        'tenants'     => assie4_get_tenants(),
        'denah'       => get_option('assie4_pameran_denah',[]),
        'pasinbis'    => [
            'url'  => get_option('assie4_pasinbis_url',''),
            'nama' => get_option('assie4_pasinbis_nama',''),
            'desk' => get_option('assie4_pasinbis_desk',''),
            'logo' => get_option('assie4_pasinbis_logo',''),
            'ig'   => get_option('assie4_pasinbis_ig',''),
            'web'  => get_option('assie4_pasinbis_web',''),
        ],
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
});

// AJAX stats dihandle di assie4-pameran-digital.php

/* ══════════════════════════════════════════════════════
   BERITA EKSTERNAL — admin page & save handler
   ══════════════════════════════════════════════════════ */
define( 'ASSIE4_OPT_BERITA_EXT', 'assie4_berita_eksternal' );

function assie4_normalize_berita_ext( $b ) {
    $b = (array) $b;
    return [
        'id'    => sanitize_key( $b['id'] ?? uniqid('ext_') ),
        'title' => sanitize_text_field( trim( $b['title'] ?? '' ) ),
        'link'  => esc_url_raw( trim( $b['link'] ?? '' ) ),
        'date'  => sanitize_text_field( trim( $b['date'] ?? '' ) ),
        'desc'  => sanitize_textarea_field( trim( $b['desc'] ?? '' ) ),
        'thumb' => esc_url_raw( trim( $b['thumb'] ?? '' ) ),
    ];
}

function assie4_save_berita_ext() {
    if ( ! isset( $_POST['assie4_berita_ext_nonce'] ) ) return;
    if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['assie4_berita_ext_nonce'] ) ), 'assie4_berita_ext_save' ) ) return;
    if ( ! current_user_can( 'manage_options' ) ) return;

    $raw   = isset( $_POST['berita_ext'] ) ? (array) wp_unslash( $_POST['berita_ext'] ) : [];
    $items = [];
    foreach ( $raw as $b ) {
        $n = assie4_normalize_berita_ext( $b );
        if ( $n['title'] && $n['link'] ) $items[] = $n;
    }
    // Re-index IDs
    foreach ( $items as &$item ) {
        if ( empty( $item['id'] ) ) $item['id'] = uniqid('ext_');
    }
    update_option( ASSIE4_OPT_BERITA_EXT, $items );
    delete_transient( 'assie4_news_cache' );
    add_settings_error( 'assie4_berita_ext', 'saved', '✅ Berita eksternal disimpan & cache diperbarui.', 'success' );
}
add_action( 'admin_init', 'assie4_save_berita_ext' );

function assie4_admin_berita_ext() {
    $items = get_option( ASSIE4_OPT_BERITA_EXT, [] );
    settings_errors( 'assie4_berita_ext' );
    a4_header( '📰 Berita Eksternal' );
    ?>
    <p class="u-text-sm u-text-muted u-mb-lg">Tambahkan berita dari situs luar. Akan digabung &amp; diurutkan bersama berita PASINBIS di grid halaman pameran.</p>

    <form method="post" id="a4-ext-form">
    <?php wp_nonce_field( 'assie4_berita_ext_save', 'assie4_berita_ext_nonce' ); ?>

    <div class="a4-card">
        <div class="a4-card-head">
            Daftar Berita Eksternal
            <span class="a4-badge a4-badge-blue"><?php echo count($items); ?> berita</span>
        </div>

        <div id="a4-ext-list">
        <?php if ( empty($items) ): ?>
        <div class="a4-ext-empty" id="a4-ext-empty">📭 Belum ada berita eksternal. Klik "+ Tambah Berita" untuk mulai.</div>
        <?php else: ?>
        <?php foreach ( $items as $i => $b ): ?>
        <div class="a4-ext-item">
            <div class="a4-ext-item-head">
                <span class="a4-ext-item-num">📰 Berita #<?php echo $i + 1; ?></span>
                <button type="button" onclick="a4ExtRemove(this)" class="a4-btn-danger">✕ Hapus</button>
            </div>
            <input type="hidden" name="berita_ext[<?php echo $i; ?>][id]" value="<?php echo esc_attr($b['id']); ?>">
            <div class="a4-row">
                <div class="a4-field">
                    <label>Judul Berita <span style="color:#dc2626">*</span></label>
                    <input type="text" name="berita_ext[<?php echo $i; ?>][title]" value="<?php echo esc_attr($b['title']); ?>" placeholder="Judul artikel..." required>
                </div>
                <div class="a4-field">
                    <label>Link URL <span style="color:#dc2626">*</span></label>
                    <input type="url" name="berita_ext[<?php echo $i; ?>][link]" value="<?php echo esc_attr($b['link']); ?>" placeholder="https://..." required>
                </div>
            </div>
            <div class="a4-row">
                <div class="a4-field">
                    <label>Tanggal Tayang</label>
                    <input type="date" name="berita_ext[<?php echo $i; ?>][date]" value="<?php echo esc_attr($b['date']); ?>">
                </div>
                <div class="a4-field">
                    <label>URL Gambar <small>opsional</small></label>
                    <input type="url" name="berita_ext[<?php echo $i; ?>][thumb]" value="<?php echo esc_attr($b['thumb'] ?? ''); ?>" placeholder="https://...gambar.jpg">
                </div>
            </div>
            <div class="a4-field">
                <label>Deskripsi Singkat <small>opsional · maks 160 karakter</small></label>
                <textarea name="berita_ext[<?php echo $i; ?>][desc]" rows="2" placeholder="Ringkasan singkat artikel..." maxlength="160"><?php echo esc_textarea($b['desc'] ?? ''); ?></textarea>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
        </div>

        <button type="button" id="a4-ext-add" class="a4-btn-gold u-mt-md">+ Tambah Berita</button>
    </div>

    <button type="submit" class="a4-btn-primary">💾 Simpan Semua Berita</button>
    </form>
    </div>

    <script>
    var a4ExtIdx = <?php echo count($items); ?>;

    function a4ExtRemove(btn) {
        var item = btn.closest('.a4-ext-item');
        item.style.opacity = '0';
        item.style.transition = 'opacity .2s';
        setTimeout(function(){ item.remove(); a4ExtRenum(); }, 200);
    }

    function a4ExtRenum() {
        document.querySelectorAll('.a4-ext-item').forEach(function(el, idx) {
            var num = el.querySelector('.a4-ext-item-num');
            if (num) num.textContent = '📰 Berita #' + (idx + 1);
        });
        var empty = document.getElementById('a4-ext-empty');
        var list  = document.getElementById('a4-ext-list');
        if (list && !list.querySelector('.a4-ext-item')) {
            if (!empty) {
                var d = document.createElement('div');
                d.className = 'a4-ext-empty'; d.id = 'a4-ext-empty';
                d.textContent = '📭 Belum ada berita eksternal. Klik "+ Tambah Berita" untuk mulai.';
                list.appendChild(d);
            }
        }
    }

    document.getElementById('a4-ext-add').addEventListener('click', function(){
        var emptyEl = document.getElementById('a4-ext-empty');
        if (emptyEl) emptyEl.remove();
        var i = a4ExtIdx++;
        var div = document.createElement('div');
        div.className = 'a4-ext-item';
        div.innerHTML =
            '<div class="a4-ext-item-head">'
            + '<span class="a4-ext-item-num">📰 Berita #' + (document.querySelectorAll('.a4-ext-item').length + 1) + '</span>'
            + '<button type="button" onclick="a4ExtRemove(this)" class="a4-btn-danger">✕ Hapus</button>'
            + '</div>'
            + '<input type="hidden" name="berita_ext[' + i + '][id]" value="">'
            + '<div class="a4-row">'
            +   '<div class="a4-field"><label>Judul Berita <span style="color:#dc2626">*</span></label>'
            +   '<input type="text" name="berita_ext[' + i + '][title]" placeholder="Judul artikel..." required></div>'
            +   '<div class="a4-field"><label>Link URL <span style="color:#dc2626">*</span></label>'
            +   '<input type="url" name="berita_ext[' + i + '][link]" placeholder="https://..." required></div>'
            + '</div>'
            + '<div class="a4-row">'
            +   '<div class="a4-field"><label>Tanggal Tayang</label>'
            +   '<input type="date" name="berita_ext[' + i + '][date]"></div>'
            +   '<div class="a4-field"><label>URL Gambar <small>opsional</small></label>'
            +   '<input type="url" name="berita_ext[' + i + '][thumb]" placeholder="https://...gambar.jpg"></div>'
            + '</div>'
            + '<div class="a4-field"><label>Deskripsi Singkat <small>opsional · maks 160 karakter</small></label>'
            + '<textarea name="berita_ext[' + i + '][desc]" rows="2" placeholder="Ringkasan singkat artikel..." maxlength="160"></textarea></div>';
        document.getElementById('a4-ext-list').appendChild(div);
        div.style.opacity = '0'; div.style.transition = 'opacity .25s';
        requestAnimationFrame(function(){ div.style.opacity = '1'; });
        div.querySelector('input[type=text]').focus();
    });
    </script>
    <?php
}

