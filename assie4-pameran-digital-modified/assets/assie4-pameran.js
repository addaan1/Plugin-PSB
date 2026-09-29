/* ═══════════════════════════════════════════════════════
   ASSIE IV 2026 — Pameran Digital · WordPress JS v2.6
   ═══════════════════════════════════════════════════════ */
(function () {
  'use strict';

  /* ══════════════════════════════════════════════════════
     DATA MASTER — default, akan di-override dari ASSIE4_DB
     ═══════════════════════════════════════════════════════ */
  var DATA = {
    info:    { date:'6-8 November 2026', location:'Grand City Atrium, Surabaya', org:'PASINBIS Universitas Airlangga', timeOpen:'10:00', timeClose:'22:00' },
    slides:  [
      { title:'ASSIE IV 2026', subtitle:'Airlangga Startup Summit & Innovation Expo', desc:'Ajang pameran startup & inovasi terbesar di Jawa Timur. 3 hari penuh inovasi.', cta:'Jelajahi Pameran', link:'#denah', bg:'linear-gradient(135deg,#03050e 0%,#0c1a40 100%)' },
      { title:'Inovasi Tanpa Batas', subtitle:'Grand City Atrium · Surabaya', desc:'Temui inovator muda dan ekosistem startup Jawa Timur.', cta:'Lihat Denah Booth', link:'#denah', bg:'linear-gradient(135deg,#03050e 0%,#0d200e 100%)' },
      { title:'Dukung Startup Lokal', subtitle:'TokoUA · tokoua.unair.ac.id', desc:'Beli produk tenant pameran secara online melalui TokoUA.', cta:'Kunjungi TokoUA', link:'https://tokoua.unair.ac.id/', bg:'linear-gradient(135deg,#03050e 0%,#1a0a00 100%)' },
    ],
    ticker:  ['Selamat datang di ASSIE IV 2026','6-8 November 2026 · Grand City Atrium Surabaya','Booth startup & inovasi','Belanja produk tenant online di tokoua.unair.ac.id','Presensi digital tersedia di setiap booth','PASINBIS Universitas Airlangga'],
    rundown: {
      days:   [{ label:'Jumat, 6 November 2026' },{ label:'Sabtu, 7 November 2026' },{ label:'Minggu, 8 November 2026' }],
      events: [
        { day:0,time:'13.00',end:'15.30',name:'Airlangga Business Matching 2026 - ATAVI',type:'panel',loc:'Ruang Business Matching' },
        { day:0,time:'15.30',end:'17.00',name:'Opening Ceremony + Launching Produk Inovasi',type:'keynote',loc:'Main Stage' },
        { day:0,time:'17.00',end:'17.30',name:'Break',                              type:'break',     loc:'—' },
        { day:0,time:'17.30',end:'19.30',name:'Roblox Competition',                 type:'workshop',  loc:'Hall' },
        { day:0,time:'19.45',end:'20.45',name:'Acoustic Band Performance',          type:'networking',loc:'Main Stage' },
        { day:0,time:'21.00',end:'21.30',name:'Closing Day 1',                      type:'award',     loc:'Main Stage' },
        { day:1,time:'10.00',end:'10.30',name:'Opening',                            type:'keynote',   loc:'Main Stage' },
        { day:1,time:'10.30',end:'13.40',name:'Workshop Beregu Startup ATAVI',      type:'workshop',  loc:'Hall' },
        { day:1,time:'13.50',end:'18.00',name:'Mozilla Legend E-Sport Competition', type:'workshop',  loc:'Hall' },
        { day:1,time:'19.40',end:'20.40',name:'Acoustic Band Perform',              type:'networking',loc:'Main Stage' },
        { day:1,time:'20.40',end:'21.10',name:'Closing Day 2',                      type:'award',     loc:'Main Stage' },
        { day:2,time:'10.00',end:'10.05',name:'Opening',                            type:'keynote',   loc:'Main Stage' },
        { day:2,time:'10.05',end:'12.35',name:'ASSIE El Got Talent',                type:'networking',loc:'Main Stage' },
        { day:2,time:'13.05',end:'15.05',name:'Talkshow Science Behind Glowing Skin',type:'panel',    loc:'Main Stage' },
        { day:2,time:'15.35',end:'16.35',name:'El Got Talent',                      type:'networking',loc:'Main Stage' },
        { day:2,time:'16.35',end:'18.55',name:'Acoustic Band Perform',              type:'networking',loc:'Main Stage' },
        { day:2,time:'18.55',end:'20.00',name:'Closing Ceremony',                   type:'award',     loc:'Main Stage' },
      ]
    },
    denah:   [],
    tenants: [
    {
        "id": "a1",
        "booth_no": 1,
        "code": "A1",
        "cluster": 1,
        "area": "A",
        "name": "Fakultas Kedokteran",
        "instansi": "Fakultas Kedokteran",
        "pic": "Reny I'tishom",
        "cat": "Internal UNAIR",
        "desc": "Fakultas Kedokteran Universitas Airlangga (FK Unair) di Surabaya merupakan salah satu fakultas kedokteran tertua dan paling bersejarah di Indonesia. Sejarahnya berakar dari tradisi pendidikan medis era Hindia Belanda yang diawali oleh pencerahan Sekolah Dokter Jawa pada pertengahan abad ke-19.\n\nSecara resmi, cikal bakal FK Unair berdiri pada 1 November 1913 di Surabaya dengan nama NIAS (Nederlandsch Indische Artsen School). Lembaga ini mencetak para dokter pribumi yang berperan besar dalam pelayanan kesehatan dan pergerakan nasional. Memasuki masa pendudukan Jepang, NIAS berganti nama menjadi Surabaya Ika Daigaku. Setelah kemerdekaan, sekolah ini sempat berstatus sebagai cabang Fakultas Kedokteran Universitas Indonesia (FK UI) sebelum akhirnya diresmikan oleh Presiden Soekarno menjadi bagian dari Universitas Airlangga pada 10 November 1954.\n\nSaat ini, FK Unair menjadi salah satu pusat pendidikan kedokteran unggulan berakreditasi internasional di Indonesia. Didukung oleh jaringan rumah sakit pendidikan utama seperti RSUD Dr. Soetomo dan Rumah Sakit Universitas Airlangga (RSUA), FK Unair terus melahirkan tenaga medis bertaraf global, memperkuat riset kesehatan, dan menjaga warisan sejarahnya sebagai pilar kedokteran tanah air.",
        "tags": [
            "Internal UNAIR",
            "UNAIR",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/fk_unair.png",
        "contact": "ritishom@fk.unair.ac.id & humas@fk.unair.ac.id",
        "whatsapp": "08121644432 & 085961510996",
        "web": "https://fk.unair.ac.id/",
        "instagram": "instagram.com/fk_unair",
        "facebook": "facebook.com/MedicineUNAIR",
        "twitter": "x.com/FK_UNAIR_ofc",
        "transaksi": "Ya"
    },
    {
        "id": "a2",
        "booth_no": 2,
        "code": "A2",
        "cluster": 1,
        "area": "A",
        "name": "Fakultas Kedokteran Gigi Universitas Airlangga",
        "instansi": "Fakultas Kedokteran Gigi Universitas Airlangga",
        "pic": "Dr. Andari Sarasati drg.",
        "cat": "Internal UNAIR",
        "desc": "FKG UNAIR merupakan institusi pendidikan kedokteran gigi unggulan di Indonesia dengan kekuatan dalam pendidikan, riset, inovasi, dan pengabdian masyarakat. Berbagai riset dan inovasi produk dikembangkan untuk menghasilkan solusi kesehatan gigi dan mulut  yang berdampak dan berpotensi dikolaborasikan serta dihilirkan bersama industri dan pemerintah.",
        "tags": [
            "Internal UNAIR",
            "UNAIR",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/fkg.png",
        "contact": "andari.sarasati@fkg.unair.ac.id",
        "whatsapp": "81333343938.0",
        "web": "https://unair.ac.id/fakultas-kedokteran-gigi/",
        "instagram": "Dental Medicine UNAIR (@fkg.unair)",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "a3",
        "booth_no": 3,
        "code": "A3",
        "cluster": 1,
        "area": "A",
        "name": "Fakultas Farmasi UNAIR",
        "instansi": "Fakultas Farmasi UNAIR",
        "pic": "Yusuf Alif Pratama",
        "cat": "Internal UNAIR",
        "desc": "Produk inovasi FF UNAIR",
        "tags": [
            "Internal UNAIR",
            "UNAIR",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/farmasi_unair.png",
        "contact": "yusuf.alif@ff.unair.ac.id",
        "whatsapp": "089605257473",
        "web": "https://ff.unair.ac.id",
        "instagram": "ff.unair",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "a4",
        "booth_no": 4,
        "code": "A4",
        "cluster": 1,
        "area": "A",
        "name": "Fakultas Kedokteran Hewan Universitas Airlangga",
        "instansi": "Fakultas Kedokteran Hewan Universitas Airlangga",
        "pic": "Dhandy Koesoemo Wardhana, drh.,M.Vet.,Ph.D",
        "cat": "Internal UNAIR",
        "desc": "Fakultas Kedokteran Hewan Universitas Airlangga (FKH UNAIR) merupakan salah satu institusi pendidikan kedokteran hewan terkemuka di Indonesia yang unggul dalam pendidikan, penelitian, dan pengabdian kepada masyarakat. Didukung sumber daya akademik yang kompeten, fasilitas pendidikan dan penelitian yang memadai, serta jejaring kerja sama nasional dan internasional, FKH UNAIR berkomitmen menghasilkan lulusan dan inovasi yang berdaya saing serta berkontribusi nyata bagi kesehatan hewan dan kesehatan masyarakat. Arah penelitian FKH UNAIR diselaraskan dengan rencana pengembangan institusi, kebutuhan nasional, dan tren global, dengan orientasi utama pada penelitian terapan yang berujung pada hilirisasi. Melalui riset yang berorientasi produk, FKH UNAIR mendorong lahirnya luaran kekayaan intelektual, khususnya paten dan paten sederhana yang aplikatif dan siap dimanfaatkan pengguna, mulai dari kandidat vaksin, kit diagnostik, sediaan obat hewan dan herbal, hingga teknologi reproduksi dan pakan fungsional. Luaran tersebut dikembangkan bersama mitra industri, pemerintah, dan masyarakat agar tidak berhenti sebagai publikasi ilmiah, melainkan bertransformasi menjadi produk dan layanan yang memberi manfaat ekonomi dan sosial secara langsung.",
        "tags": [
            "Internal UNAIR",
            "UNAIR",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/fkh_unair.png",
        "contact": "dhandy.koesoemo.wardhana@fkh.unair.ac.id",
        "whatsapp": "081553121891",
        "web": "https://fkh.unair.ac.id/",
        "instagram": "humasfkhunair",
        "facebook": "",
        "twitter": "FkhUnair",
        "transaksi": "Ya"
    },
    {
        "id": "a5",
        "booth_no": 5,
        "code": "A5",
        "cluster": 1,
        "area": "A",
        "name": "FaST_Booth",
        "instansi": "Fakultas Sains dan Teknologi UNAIR",
        "pic": "Dr. M. Fariz Fadillah Mardianto, M.Si",
        "cat": "Internal UNAIR",
        "desc": "Booth memamerkan karya inovasi dosen Fakultas Sains dan Teknologi Universitas Airlangga dari hasil riset dan pengabdian masyarakat yang berpotensi untuk dikembangkan dalam hilirisasi untuk keberlanjutan",
        "tags": [
            "Internal UNAIR",
            "UNAIR",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/fast_unair.png",
        "contact": "m.fariz.fadillah.m@fst.unair.ac.id",
        "whatsapp": "081330733130",
        "web": "https://fst.unair.ac.id/",
        "instagram": "@fst_unair",
        "facebook": "Fst Unair",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "a6",
        "booth_no": 6,
        "code": "A6",
        "cluster": 1,
        "area": "A",
        "name": "FTMM UNAIR",
        "instansi": "FTMM UNAIR",
        "pic": "Vinanci Intan Widriani, S.M.",
        "cat": "Internal UNAIR",
        "desc": "Produk inovasi dari Fakultas Teknologi Maju dan Multidisiplin",
        "tags": [
            "Internal UNAIR",
            "UNAIR",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/unair.png",
        "contact": "vinanci@staf.unair.ac.id",
        "whatsapp": "0822-3216-6441",
        "web": "https://ftmm.unair.ac.id/",
        "instagram": "ftmmunair",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "a7",
        "booth_no": 7,
        "code": "A7",
        "cluster": 1,
        "area": "A",
        "name": "Fakultas Vokasi (Departemen Kesehatan)",
        "instansi": "Universitas Airlangga/ Fakultas Vokasi/ Departemen Kesehatan",
        "pic": "IIF HANIFA NURROSYIDAH",
        "cat": "Internal UNAIR",
        "desc": "Booth ini menampilkan hasil riset, karya inovasi, dan produk praktikum mahasiswa dari Departemen Kesehatan dan Fakultas Vokasi, mencakup Program Studi Pengobatan Tradisional, Radiologi, Teknik Gigi, dan program studi kesehatan lainnya. Pengunjung dapat menyaksikan langsung berbagai inovasi di bidang kesehatan, mulai dari produk herbal dan terapi tradisional berbasis bukti ilmiah, teknologi pencitraan radiologi, hasil karya teknik gigi (protesa, alat orthodontik, dan model anatomi gigi), hingga inovasi alat kesehatan penunjang lainnya. Booth ini menjadi bukti nyata kontribusi dunia pendidikan vokasi kesehatan dalam menghadirkan solusi aplikatif yang siap dihilirisasi ke masyarakat dan industri.",
        "tags": [
            "Internal UNAIR",
            "UNAIR",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/vokasi_unair.png",
        "contact": "hanifa.nurrosyidah@vokasi.unair.ac.id",
        "whatsapp": "085190648711",
        "web": "",
        "instagram": "",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "a8",
        "booth_no": 8,
        "code": "A8",
        "cluster": 1,
        "area": "A",
        "name": "FPK UNAIR",
        "instansi": "Fakultas Perikanan dan Kelautan Universitas Airlangga",
        "pic": "Daruti Dinda Nindarwi",
        "cat": "Internal UNAIR",
        "desc": "FPK UNAIR menghadirkan inovasi berbasis riset perikanan dan kelautan untuk menciptakan produk bernilai tambah dan berkelanjutan. Melalui kolaborasi antara ilmu pengetahuan, teknologi, dan industri, FPK UNAIR mendorong hilirisasi inovasi untuk menjawab kebutuhan masyarakat dan membuka peluang pengembangan bisnis masa depan.",
        "tags": [
            "Internal UNAIR",
            "UNAIR",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/fpk_unair.png",
        "contact": "daruti-dinda-n@fpk.unair.ac.id",
        "whatsapp": "+62 822-3172-4191",
        "web": "https://fpk.unair.ac.id",
        "instagram": "fpkunair",
        "facebook": "Fakultas Perikanan dan Kelautan",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "a9",
        "booth_no": 9,
        "code": "A9",
        "cluster": 1,
        "area": "A",
        "name": "Fakultas Ekonomi dan Bisnis",
        "instansi": "Fakultas Ekonomi dan Bisnis Universitas Airlangga",
        "pic": "",
        "cat": "Internal UNAIR",
        "desc": "Booth resmi Fakultas Ekonomi dan Bisnis (FEB) Universitas Airlangga.",
        "tags": [
            "Internal UNAIR",
            "UNAIR"
        ],
        "logo": "assets/tenant-logos/feb_unair.png",
        "contact": "",
        "whatsapp": "",
        "web": "https://feb.unair.ac.id/",
        "instagram": "",
        "facebook": "",
        "twitter": "",
        "transaksi": ""
    },
    {
        "id": "a10",
        "booth_no": 10,
        "code": "A10",
        "cluster": 1,
        "area": "A",
        "name": "Public Health UNAIR",
        "instansi": "Fakultas Kesehatan Masyarakat UNAIR",
        "pic": "Rizna Notarianti",
        "cat": "Internal UNAIR",
        "desc": "Booth Public Health UNAIR merupakan ruang yang memperkenalkan dan memasarkan berbagai produk inovasi karya dosen dan mahasiswa Fakultas Kesehatan Masyarakat Universitas Airlangga. Booth ini menghadirkan beragam inovasi di bidang gizi dan kesehatan masyarakat yang dikembangkan berdasarkan kreativitas, keilmuan, serta kebutuhan masyarakat.\n\nMelalui produk-produk yang ditawarkan, Booth FKM UNAIR menjadi wadah untuk mempertemukan hasil inovasi akademik dengan masyarakat secara lebih luas. Setiap produk diharapkan tidak hanya memiliki nilai guna dan nilai ekonomi, tetapi juga memberikan kontribusi nyata dalam mendukung peningkatan kualitas kesehatan dan kesejahteraan masyarakat.\n\nDengan semangat “Dari Kampus untuk Masyarakat”, Booth FKM UNAIR hadir sebagai representasi kreativitas dan inovasi sivitas akademika FKM UNAIR, sekaligus mendorong pemanfaatan hasil karya dosen dan mahasiswa agar dapat memberikan dampak positif bagi masyarakat.",
        "tags": [
            "Internal UNAIR",
            "UNAIR",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/fkm.jpg",
        "contact": "riznanotarianti@fkm.unair.ac.id",
        "whatsapp": "081904251396",
        "web": "",
        "instagram": "",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "a11",
        "booth_no": 11,
        "code": "A11",
        "cluster": 1,
        "area": "A",
        "name": "FIB UNAIR",
        "instansi": "FIB UNAIR BERBUDI DAN BERBUDAYA",
        "pic": "Nuri Hermawan",
        "cat": "Internal UNAIR",
        "desc": "FIB UNAIR mengusung pameran inovsi berbasih budaya. Selain itu, inovasi ditujukan untuk memberikan edukasi dan pemahaman yang komprehensif berkenaan dengan budi dan budaya.",
        "tags": [
            "Internal UNAIR",
            "UNAIR",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/fib.jpg",
        "contact": "nuri.hermawan@fib.unair.ac.id",
        "whatsapp": "085736753801",
        "web": "https://fib.unair.ac.id/fib-main/",
        "instagram": "https://www.instagram.com/fib.unair/?hl=en",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "a12",
        "booth_no": 12,
        "code": "A12",
        "cluster": 1,
        "area": "A",
        "name": "FIKKIA UNAIR",
        "instansi": "FIKKIA UNAIR",
        "pic": "Bintang Gumilang",
        "cat": "Internal UNAIR",
        "desc": "Produk inovasi mahasiswa dan dosen di Fakultas Ilmu Kesehatan, Kedokteran, dan Ilmu Alam Universitas Airlangga",
        "tags": [
            "Internal UNAIR",
            "UNAIR",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/fikkia_unair.png",
        "contact": "bintang.gumilang@staf.unair.ac.id",
        "whatsapp": "08980614045",
        "web": "https://fikkia.unair.ac.id",
        "instagram": "fikkia.unair",
        "facebook": "fikkia univ airlangga",
        "twitter": "fikkia_unair",
        "transaksi": "Ya"
    },
    {
        "id": "a16",
        "booth_no": 16,
        "code": "A16",
        "cluster": 1,
        "area": "A",
        "name": "Lembaga Penyakit Tropis Universitas Airlangga",
        "instansi": "Lembaga Penyakit Tropis Universitas Airlangga",
        "pic": "Laura Navika Yamani",
        "cat": "Internal UNAIR",
        "desc": "Lembaga Penyakit Tropis (LPT) Universitas Airlangga merupakan pusat unggulan penelitian dan pengembangan dalam bidang penyakit tropis dan penyakit infeksi yang mengintegrasikan riset, inovasi, layanan, pendidikan, serta pengembangan produk kesehatan. LPT UNAIR melalui berbagai research center, termasuk Research Center for Global Emerging and Re-emerging Infectious Diseases (RC GERID), mengembangkan penelitian berbasis epidemiologi, biologi molekuler, mikrobiologi, genomik, bioinformatika, dan kesehatan masyarakat untuk menghasilkan produk dan teknologi kesehatan, seperti kit diagnostik, metode deteksi molekuler, primer dan probe, sistem surveilans, serta inovasi untuk pencegahan dan pengendalian penyakit infeksi. Dengan jejaring kolaborasi nasional dan internasional serta kemitraan dengan pemerintah, industri, dan fasilitas pelayanan kesehatan, LPT UNAIR mendorong pendekatan from research to product dan hilirisasi hasil penelitian sehingga dapat memberikan kontribusi nyata terhadap kemandirian teknologi kesehatan, penguatan surveilans penyakit infeksi, dan kesiapsiagaan menghadapi penyakit emerging, re-emerging, dan ancaman pandemi.",
        "tags": [
            "Internal UNAIR",
            "UNAIR",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/lpt_unair.png",
        "contact": "laura.navika@fkm.unair.ac.id",
        "whatsapp": "085649152890",
        "web": "https://itd.unair.ac.id/wp/",
        "instagram": "https://www.instagram.com/itd_unair/",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "a17",
        "booth_no": 17,
        "code": "A17",
        "cluster": 1,
        "area": "A",
        "name": "Airlangga Enterprise",
        "instansi": "Airlangga Enterprise",
        "pic": "Rio Yuniar Dwinanta",
        "cat": "Internal UNAIR",
        "desc": "Booth Airlangga Enterprise akan menampilkan produk Amerta Water dan ruangan yang disewakan melalui Ditpilar Universitas Airlangga.",
        "tags": [
            "Internal UNAIR",
            "UNAIR",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/airlangga_enterprise.png",
        "contact": "rio.yuniar2406@gmail.com",
        "whatsapp": "+6282257814415",
        "web": "https://airlanggaenterprise.unair.ac.id",
        "instagram": "airlangga_enterprise",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "a18",
        "booth_no": 18,
        "code": "A18",
        "cluster": 1,
        "area": "A",
        "name": "Dormitory Center",
        "instansi": "Dormitory Center",
        "pic": "Aria Heru Setiawan",
        "cat": "Internal UNAIR",
        "desc": "Pusat Asrama Mahasiswa Universitas Airlangga merupakan fasilitas hunian mahasiswa yang nyaman, aman, dan mendukung pengembangan karakter serta kompetensi. Berlokasi di Kampus C UNAIR, asrama menjadi ruang tumbuh bagi mahasiswa melalui berbagai kegiatan edukatif dan pengembangan diri.",
        "tags": [
            "Internal UNAIR",
            "UNAIR",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/dormitory_center.png",
        "contact": "ariaheru@staf.unair.ac.id",
        "whatsapp": "08819301869",
        "web": "https://asrama.unair.ac.id",
        "instagram": "dormitoryunair",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "a19",
        "booth_no": 19,
        "code": "A19",
        "cluster": 1,
        "area": "A",
        "name": "PUSPAS UNAIR",
        "instansi": "Pusat Pengelolaan Dana Sosial",
        "pic": "Nikmatul Fuadah",
        "cat": "Internal UNAIR",
        "desc": "MEnampilkan pengembangan bisnis dari pengelolaan wakaf produktif",
        "tags": [
            "Internal UNAIR",
            "UNAIR",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/puspas_unair.png",
        "contact": "info@puspas.unair.ac.id",
        "whatsapp": "081327976923",
        "web": "https://puspas.unair.ac.id",
        "instagram": "@puspasunair_official",
        "facebook": "pusat pengelolaan dana sosial universitas airlangga",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "a20",
        "booth_no": 20,
        "code": "A20",
        "cluster": 1,
        "area": "A",
        "name": "Pusat Halal UNAIR",
        "instansi": "Universitas Airlangga",
        "pic": "Muhammad Risqi Ihya Ramdhan",
        "cat": "Internal UNAIR",
        "desc": "Pusat Halal atau sebelumnya dikenal sebagai Pusat Riset dan Pengembangan Produk Halal Universitas Airlangga (PRPPH UNAIR) dibentuk untuk menjalankan fungsi sebagai Halal Research Center (Pusat Kajian Halal) sekaligus Halal Center, guna mendukung peran aktif institusi perguruan tinggi, khususnya dalam bidang penelitian dan pengabdian kepada masyarakat.",
        "tags": [
            "Internal UNAIR",
            "UNAIR",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/pusat_halal.png",
        "contact": "info@halal.unair.ac.id",
        "whatsapp": "089697458211",
        "web": "https://halal.unair.ac.id/",
        "instagram": "https://www.instagram.com/halalunair/",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "a21",
        "booth_no": 21,
        "code": "A21",
        "cluster": 1,
        "area": "A",
        "name": "Pusat Bahasa dan Multibudaya",
        "instansi": "Pusat Bahasa dan Multibudaya",
        "pic": "Iyun Witari",
        "cat": "Internal UNAIR",
        "desc": "*Pusat Bahasa dan Multibudaya (Pusbamulya) Universitas Airlangga* merupakan unit penunjang penyeleggara layanan bahasa dan kebudayaan profesional di lingkungan Universitas Airlangga. Berada di bawah koordinasi pimpinan universitas, Pusbamulya berkomitmen mendukung penguatan akademik, internasionalisasi, serta pengembangan kompetensi sumber daya manusia.\n\nLayanan unggulan Pusbamulya mencakup tiga bidang utama:\n\n1. *Pengujian Bahasa:* Penyelenggaraan tes kemahiran bahasa terstandar, seperti English Language Proficiency Test (ELPT UNAIR), TOEFL ITP, NAT-TEST (Bahasa Jepang), dan uji kompetensi bahasa lainnya secara luring maupun daring.\n2. *Pelatihan dan Kursus Bahasa:* Program pelatihan bahasa Inggris (ELPT/IELTS preparation, general conversation, English for specific purposes) serta kelas bahasa asing seperti Jepang, Prancis, Belanda, dan BIPA.\n3. *Penerjemahan dan Penjurubahasaan:* Jasa penerjemahan dokumen resmi/akademik, proofreading, serta layanan interpreter profesional.\n\nDidukung oleh staf pengajar berpengalaman, kurikulum berkualitas, dan fasilitas modern, Pusbamulya tidak hanya melayani civitas akademika UNAIR, melainkan juga terbuka bagi masyarakat umum, instansi pemerintah, serta mitra korporat.",
        "tags": [
            "Internal UNAIR",
            "UNAIR",
            "Transaksi Booth"
        ],
        "logo": "https://1drv.ms/i/c/d980f1cf28fccf2b/IQA7mB1lMLQjRaB9Z2HsWQWFASJWfNf7SPIL0g6QtXlb2ig?e=hYNyEj",
        "contact": "iyunwitari@staf.unair.ac.id",
        "whatsapp": "+62 812-1691-5819",
        "web": "https://pusatbahasa.unair.ac.id/",
        "instagram": "@pusatbahasaunair",
        "facebook": "https://www.facebook.com/pusbaunair",
        "twitter": "https://x.com/pusbamulya",
        "transaksi": "Ya"
    },
    {
        "id": "d1",
        "booth_no": 22,
        "code": "D1",
        "cluster": 2,
        "area": "D",
        "name": "Airlangga Bilirubin Sun",
        "instansi": "PT Medika Karya Airlangga",
        "pic": "Hasbi Assidiq",
        "cat": "Kesehatan & Farmasi",
        "desc": "AirBiliSun adalah inovasi fototerapi cahaya matahari terfilter yang aman untuk bayi kuning, mencegah paparan sinar UV, serta mendukung pemerataan akses fototerapi, terutama di wilayah 3T Indonesia.",
        "tags": [
            "Kesehatan & Farmasi",
            "Startup",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/airbilisun.png",
        "contact": "hasbi.assidiq1990@gmail.com",
        "whatsapp": "+62 851-1755-2990",
        "web": "https://airbilisun.com",
        "instagram": "airbilisun",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya",
        "desk": "PT Medika Karya Airlangga merupakan startup berbasis teknologi kesehatan yang telah berbadan hukum dan menjadi salah satu bentuk implementasi Indikator Kinerja Utama (IKU) 2, melalui pengembangan startup berbasis teknologi yang melibatkan dosen, alumni, dan mahasiswa Universitas Airlangga (UNAIR). AirBiliSun adalah inovasi fototerapi cahaya matahari terfilter yang aman untuk bayi kuning, mencegah hiperbilirubinemia dengan efisien dan ramah lingkungan."
    },
    {
        "id": "d2",
        "booth_no": 23,
        "code": "D2",
        "cluster": 2,
        "area": "D",
        "name": "CESGS Universitas Airlangga",
        "instansi": "CESGS Universitas Airlangga",
        "pic": "Nisa Andini Faradina",
        "cat": "Internal UNAIR",
        "desc": "Center for Environmental, Social, and Governance Studies (CESGS) adalah pusat penelitian di bawah naungan Universitas Airlangga yang berfokus pada penanganan isu-isu keberlanjutan.",
        "tags": [
            "Internal UNAIR",
            "Startup",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/unair.png",
        "contact": "esgi.dataset@gmail.com",
        "whatsapp": "085171700942",
        "web": "https://cesgs.unair.ac.id/",
        "instagram": "cesgs.unair",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "d3",
        "booth_no": 24,
        "code": "D3",
        "cluster": 2,
        "area": "D",
        "name": "Unit Layanan Pengujian (ULP)",
        "instansi": "Unit Layanan Pengujian Fakultas Farmasi Unair (ULPFFUA)",
        "pic": "Rizka Elvira Puteri",
        "cat": "Internal UNAIR",
        "desc": "Unit Layanan Pengujian Fakultas Farmasi Universitas Airlangga adalah Laboratorium pengujian kimia dan mikrobilogis produk obat, makanan dan kosmetik. ULP-FFUA merupakan salah satu unit pendukung Fakultas Farmasi Universitas Airlangga yang didirikan dan dikembangkan untuk memberikan pelayanan pengujian untuk keperluan pendidikan, penelitian dan pengabdian masyarakat.\n\nUntuk Menjamin Kualitas Layanan pengujiannya ULP-FFUA pada tahun 2005 mulai mengajukan sertifikasi ISO 17025 dengan no LD-325-IDN. Untuk meningkatkan performa Unit Layanan Pengujian lebih lanjut, maka dilakukan penataan manajemen dan restruksi organisasi berdasarkan SK Dekan Fakultas Farmasi Unair no.2284/JO3.1.20/PP/2008 tertanggal 31 Oktober 2008.",
        "tags": [
            "Internal UNAIR",
            "Startup",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/farmasi_unair.png",
        "contact": "ulpffunair@gmail.com",
        "whatsapp": "082234079377",
        "web": "https://ff.unair.ac.id/pgs/418/contact",
        "instagram": "ulp_unair",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "d4",
        "booth_no": 25,
        "code": "D4",
        "cluster": 2,
        "area": "D",
        "name": "PUI-PT Bisnis Berkelanjutan",
        "instansi": "Universitas Airlangga",
        "pic": "",
        "cat": "Riset & Pengembangan",
        "desc": "Pusat Unggulan Ipteks Perguruan Tinggi Bisnis Berkelanjutan Universitas Airlangga.",
        "tags": [
            "Riset & Pengembangan",
            "Startup"
        ],
        "logo": "assets/tenant-logos/unair.png",
        "contact": "",
        "whatsapp": "",
        "web": "",
        "instagram": "",
        "facebook": "",
        "twitter": "",
        "transaksi": ""
    },
    {
        "id": "d5",
        "booth_no": 26,
        "code": "D5",
        "cluster": 2,
        "area": "D",
        "name": "Onggu Honey",
        "instansi": "CV. Rumah Matahari Pagi",
        "pic": "Arrissa Fauziarachman",
        "cat": "PGN",
        "desc": "Onggu Honey dari CV. Rumah Matahari Pagi menghadirkan 100% madu hutan Indonesia dari nektar, murni, alami, dan teruji keaslian melalui metode FTIR. Berkomitmen pada keamanan pangan, konservasi lebah, edukasi, eduwisata, serta pemberdayaan peternak lebah madu dan pemanen madu hutan liar.",
        "tags": [
            "PGN",
            "Startup",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/onggu_honey.png",
        "contact": "rumahmataharipagi@gmail.com",
        "whatsapp": "+62 813-5772-9664",
        "web": "https://sites.google.com/view/onggu-honey/beranda",
        "instagram": "https://www.instagram.com/maduonggu/ https://www.instagram.com/ongguhoney/",
        "facebook": "https://www.facebook.com/madu.onggu.1/",
        "twitter": "",
        "transaksi": "Ya",
        "desk": "Onggu Honey dari CV. Rumah Matahari Pagi menghadirkan 100% madu hutan Indonesia murni dari nektar alami, teruji keasliannya melalui metode FTIR (Fourier Transform Infrared Spectroscopy) di laboratorium terakreditasi."
    },
    {
        "id": "d6",
        "booth_no": 27,
        "code": "D6",
        "cluster": 2,
        "area": "D",
        "name": "Espresso by Kopi Setengah Serious",
        "instansi": "Espresso by Kopi Setengah Serious",
        "pic": "Eka",
        "cat": "Food & Beverage",
        "desc": "Kopi Setengah Serious adalah produsen espresso literan dari Surabaya, yang menjadi solusi simpel dan mudah untuk membuat kopi enak ala kafe tanpa harus investasi alat. \n‎\n‎Praktis tinggal tuang dan campur dengan air atau susu, produk kami telah terjual ribuan liter di e-commerce dan digunakan oleh pemilik kafe, umkm, kedai makanan maupun kopi keliling yang sedang merintis usaha dan ingin membuat menu kopi susu yang cepat namun tetap nikmat karena 1 Liter Espresso bisa untuk membuat 25-30 gelas kopi kekinian.\n‎ \n‎Kami berbagi ide resep dan konsultasi resep kopi kekinian di Instagram & Tiktok @kopisetengahserious.",
        "tags": [
            "Food & Beverage",
            "Startup",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/kopi_serious.png",
        "contact": "kopisetengahserious@gmail.com",
        "whatsapp": "087722617299",
        "web": "https://linktr.ee/kopisetengahserious",
        "instagram": "instagram.com/kopisetengahserious",
        "facebook": "facebook.com/kopisetengahserious",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "d7",
        "booth_no": 28,
        "code": "D7",
        "cluster": 2,
        "area": "D",
        "name": "Sahabat Spondan",
        "instansi": "Sahabat Spondan",
        "pic": "AMRETA LARAS PERTIWI",
        "cat": "PGN",
        "desc": "Produk olahan siap saji yang menemani setiap kegiatanmu menjadi lebih berwarna. Menghadirkan cita rasa otentik dengan harga terjangkau yang dikemas dan disajikan dengan rasa cinta. Setiap gigitan menciptakan kehangatan dalam setiap kegiatan bersama teman, keluarga dan orang tersayang kamu.",
        "tags": [
            "PGN",
            "Startup",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/sahabat_spondan.png",
        "contact": "amretapertiwi3@gmail.com",
        "whatsapp": "085730171516",
        "web": "",
        "instagram": "https://www.instagram.com/sahabatspondan_sby?igsh=MTU1bzBzZXl1cHEzcQ==",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "d8",
        "booth_no": 29,
        "code": "D8",
        "cluster": 2,
        "area": "D",
        "name": "MULIA SAMUDRA MAJU ABADI",
        "instansi": "Mulia samudra maju abadi",
        "pic": "Muhammad Syarif Satriyo samudra",
        "cat": "Agrikultur & Akuakultur",
        "desc": "CV. Mulia Samudra Maju Abadi (MSMA) merupakan usaha yang bergerak di bidang perikanan dan akuakultur berkelanjutan, dengan fokus pada budidaya dan pengembangan komoditas ikan serta rumput laut Gracilaria. MSMA mengintegrasikan kegiatan pembenihan, budidaya, pengumpulan hasil, pengolahan, hingga pemasaran untuk menghasilkan produk perikanan berkualitas dan bernilai ekonomi.\nMSMA juga mengembangkan inovasi teknologi akuakultur, seperti IoT, pakan otomatis, monitoring kualitas air, serta konsep budidaya yang efisien dan ramah lingkungan, dengan tujuan membangun ekosistem perikanan modern, produktif, dan berkelanjutan.",
        "tags": [
            "Agrikultur & Akuakultur",
            "Startup",
            "Transaksi Booth"
        ],
        "logo": "https://www.instagram.com/muliasamudra?stkn=MWV3eTFneGxhdHk1Zw==",
        "contact": "msatriyo@magister.ciputra.ac.id",
        "whatsapp": "081259545859",
        "web": "https://Muliasamudra.com",
        "instagram": "Muliasamudra",
        "facebook": "Mulia Samudra",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "d9",
        "booth_no": 30,
        "code": "D9",
        "cluster": 2,
        "area": "D",
        "name": "Flordequeen Scalp and Hair Botanicals",
        "instansi": "Universitas Ciputra Surabaya - UC Ventures",
        "pic": "Selma Lady Diana",
        "cat": "Eksternal UNAIR",
        "desc": "Mengusung konsep eco-hair wellness, Flordequeen hadir sebagai merek perawatan rambut dan kulit kepala berbasis botani yang memadukan bahan-bahan alami pilihan dengan standar kualitas premium. Kami berkomitmen untuk menghadirkan solusi perawatan menyeluruh yang aman, efektif, serta berkelanjutan untuk kesehatan rambut dari akarnya.",
        "tags": [
            "Eksternal UNAIR",
            "Startup",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/flordequeen.png",
        "contact": "flordequeen@gmail.com",
        "whatsapp": "0817290298",
        "web": "https://flordequeen.com",
        "instagram": "@flordequeen.co",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "d10",
        "booth_no": 31,
        "code": "D10",
        "cluster": 2,
        "area": "D",
        "name": "INBIS PPNS",
        "instansi": "Politeknik Perkapalan Negeri Surabaya",
        "pic": "Yesica N Devi",
        "cat": "Eksternal UNAIR",
        "desc": "Inkubator bisnis Politeknik Perkapalan Negeri Surabaya merupakan unit yang memberikan pelayanan bantuan pendampingan bagi calon start up mulai dari inisiasi bisnis hingga scale up produk hasil riset dosen dan mahasiswa.",
        "tags": [
            "Eksternal UNAIR",
            "Startup",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/poltekpel.png",
        "contact": "yesica@ppns.ac.id",
        "whatsapp": "082332357444",
        "web": "",
        "instagram": "https://www.instagram.com/inovasippns/?hl=en",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "d11",
        "booth_no": 32,
        "code": "D11",
        "cluster": 2,
        "area": "D",
        "name": "UIN Maulana Malik Ibrahim Malang",
        "instansi": "Phytonomics Research Group",
        "pic": "apt. Novia Maulina, M. Farm.",
        "cat": "Eksternal UNAIR",
        "desc": "UIN Maliki Malang melalui Phytonomics Research Group mengembangkan inovasi bahan alam menjadi produk kesehatan dan kosmetik, seperti Hermarin, Osteprim, Malstonin, Rahza, Uvamax, dan Rootēra, melalui riset dan hilirisasi.",
        "tags": [
            "Eksternal UNAIR",
            "Startup",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/uin_malang.png",
        "contact": "noviamaulina@gmail.com",
        "whatsapp": "081296050993",
        "web": "https://fkik.uin-malang.ac.id/",
        "instagram": "https://www.instagram.com/hermarin.official?stkn=bnFxYnk5dXQxdXhj",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya",
        "desk": "UIN Maliki Malang melalui Phytonomics Research Group mengembangkan inovasi bahan alam menjadi produk kesehatan dan kosmetik, seperti Hermarin, Osteprint, dan produk herbal unggulan lainnya."
    },
    {
        "id": "c1",
        "booth_no": 38,
        "code": "C1",
        "cluster": 2,
        "area": "C",
        "name": "Balai Besar POM di Surabaya",
        "instansi": "Balai Besar POM di Surabaya",
        "pic": "Irma Rahmawati",
        "cat": "Eksternal UNAIR",
        "desc": "Layanan informasi dan konsultasi terkait registrasi dan sertifikasi Obat dan Makanan",
        "tags": [
            "Eksternal UNAIR",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/bpom_surabaya.png",
        "contact": "sertifikasisby@gmail.com ; irma.rahmawati@pom.go.id",
        "whatsapp": "085645397002",
        "web": "https://surabaya.pom.go.id/",
        "instagram": "bpom.surabaya",
        "facebook": "Balai Besar POM di Surabaya",
        "twitter": "@BPOM_Surabaya",
        "transaksi": "Ya"
    },
    {
        "id": "c4",
        "booth_no": 41,
        "code": "C4",
        "cluster": 2,
        "area": "C",
        "name": "Jamkrindo",
        "instansi": "PT Jaminan Kredit Indonesia (Jamkrindo)",
        "pic": "",
        "cat": "Sponsorship / Mitra",
        "desc": "Booth Sponsorship Jamkrindo di pameran inovasi ASSIE IV 2026.",
        "tags": [
            "Sponsorship / Mitra"
        ],
        "logo": "assets/tenant-logos/jamkrindo.png",
        "contact": "",
        "whatsapp": "",
        "web": "https://www.jamkrindo.co.id/",
        "instagram": "",
        "facebook": "",
        "twitter": "",
        "transaksi": ""
    },
    {
        "id": "f1",
        "booth_no": 51,
        "code": "F1",
        "cluster": 4,
        "area": "F",
        "name": "Bangga EVCS",
        "instansi": "Bangga EVCS",
        "pic": "Ibnu Andhika Hidayat",
        "cat": "Manufaktur",
        "desc": "Bangga EVCS merupakan sebuah inisiatif berbasis riset dari Universitas Airlangga yang berfokus pada pengembangan sistem charging kendaraan listrik (Electric Vehicle/EV). Inisiatif ini melibatkan kolaborasi antara mahasiswa dan dosen, sehingga mampu menggabungkan kekuatan inovasi, riset akademik, serta pengalaman praktis dalam menjawab kebutuhan infrastruktur pengisian daya di Indonesia yang terus berkembang.\n\nFokus utama Bangga EVCS terletak pada perancangan dan pengembangan teknologi charging yang adaptif, efisien, dan relevan dengan kondisi kelistrikan nasional. Sistem yang dikembangkan umumnya mengacu pada standar internasional, dengan kemampuan operasional pada konfigurasi 1 phase hingga 3 phase, serta rentang daya yang kompetitif untuk penggunaan residensial maupun komersial. Selain itu, Bangga EVCS juga mengintegrasikan konsep smart charging, yang memungkinkan pengguna untuk melakukan monitoring konsumsi daya, kontrol jarak jauh melalui aplikasi, serta pengaturan strategi pengisian untuk meningkatkan efisiensi energi dan menjaga keandalan sistem.\n\nDalam proses pengembangannya, Bangga EVCS menerapkan pendekatan end-to-end, mulai dari studi literatur, simulasi sistem kelistrikan, desain hardware, hingga integrasi software dan pengujian langsung. Kolaborasi antara mahasiswa dan dosen menjadi kunci dalam memastikan bahwa setiap solusi yang dihasilkan tidak hanya inovatif, tetapi juga memiliki dasar ilmiah yang kuat dan potensi implementasi nyata.\n\nLebih dari sekadar proyek riset, Bangga EVCS juga berperan sebagai wadah pengembangan kompetensi lintas bidang, baik teknis maupun non-teknis. Dengan semangat kolaborasi dan inovasi, Bangga EVCS berkomitmen untuk berkontribusi dalam percepatan pengembangan ekosistem kendaraan listrik di Indonesia, khususnya melalui solusi charging yang andal, cerdas, dan berkelanjutan.",
        "tags": [
            "Manufaktur",
            "Startup",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/bangga_evcs.png",
        "contact": "ibnuandikahidayat02@gmail.com",
        "whatsapp": "+62 811-1020-416",
        "web": "https://bangga-evcs.com/",
        "instagram": "https://www.instagram.com/bangga.evcs/?utm_source=ig_web_button_share_sheet",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "f2",
        "booth_no": 52,
        "code": "F2",
        "cluster": 4,
        "area": "F",
        "name": "KINARA INDUSTRIES",
        "instansi": "CV Kreasi Industri Nusantara",
        "pic": "Rizki Indra Pratama",
        "cat": "Manufaktur",
        "desc": "KINARA INDUSTRIES adalah startup yang bergerak dibidang manufaktur Industri, mendukung berbagai jenis Research and Development Prototiping mesin dan alat kesehatan yang berbasis di Surabaya, Jawa Timur.",
        "tags": [
            "Manufaktur",
            "Startup",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/kinara.png",
        "contact": "kreasiindustrinusantara@gmail.com",
        "whatsapp": "085136887424",
        "web": "https://www.kinaraindustries.com",
        "instagram": "@kinara.industries",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "f3",
        "booth_no": 53,
        "code": "F3",
        "cluster": 4,
        "area": "F",
        "name": "Olimnesia",
        "instansi": "Startup BPRIn",
        "pic": "Dimaz",
        "cat": "Edutech",
        "desc": "Olimnesia adalah platform edutech yang menghadirkan ekosistem kompetisi dan pembelajaran bagi pelajar. Olimnesia membantu sekolah, lembaga pendidikan, dan penyelenggara lomba dalam mengelola kompetisi secara digital, mulai dari pendaftaran, pelaksanaan ujian/CBT, hingga sertifikat dan publikasi hasil.\nBagi pelajar, Olimnesia menjadi ruang untuk mengikuti berbagai kompetisi, mengembangkan kemampuan, dan mendapatkan pengalaman belajar yang lebih seru dan bermakna.",
        "tags": [
            "Edutech",
            "Startup",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/olimnesia.png",
        "contact": "olimnesia@gmail.com",
        "whatsapp": "085102717040",
        "web": "https://Olimnesia.com",
        "instagram": "Olimnesia",
        "facebook": "Olimnesia",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "f4",
        "booth_no": 54,
        "code": "F4",
        "cluster": 4,
        "area": "F",
        "name": "PT Jobhun Membangun Indonesia",
        "instansi": "PT Jobhun Membangun Indonesia",
        "pic": "Ayu Shinta Devi",
        "cat": "Jasa",
        "desc": "Tingkatkan Skill, Dapatkan Sertifikasi, Siap Bersaing di Dunia Kerja\n\nTemukan skill terbaikmu melalui pelatihan bersama expert berpengalaman dan buktikan dengan uji kompetensi bersertifikat resmi di Jobhun.",
        "tags": [
            "Jasa",
            "Startup",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/jobhun.png",
        "contact": "info@jobhun.id",
        "whatsapp": "082336010250",
        "web": "https://www.jobhun.id",
        "instagram": "jobhun",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "f5",
        "booth_no": 55,
        "code": "F5",
        "cluster": 4,
        "area": "F",
        "name": "Serasa Djiwa",
        "instansi": "Serasa Djiwa",
        "pic": "Najway Azka Arrobbaniy",
        "cat": "Jasa",
        "desc": "Serasa Djiwa dapat diposisikan sebagai penyedia layanan psikologi yang humanis, kolaboratif, dan komprehensif, dengan cakupan layanan dari anak hingga dewasa serta individu hingga organisasi. Filosofi Compassion, Collaboration, Change menjadi dasar bahwa layanan tidak hanya berfokus pada penyelesaian masalah, tetapi juga pada proses memahami, mendampingi, dan mendorong perubahan yang bermakna.\nUntuk kegiatan pameran layanan psikologi, Serasa Djiwa dapat hadir sebagai ruang yang interaktif dan edukatif, tempat pengunjung mengenal psikologi secara lebih dekat sekaligus memahami layanan yang sesuai dengan kebutuhannya. Booth dapat memperkenalkan beberapa area utama, seperti asesmen psikologi, konseling, konsultasi, coaching, mentoring, psikoedukasi, dan pelatihan, serta layanan khusus di bidang pendidikan, perkembangan anak, dan industri-organisasi. \nKonsep pameran tidak hanya bersifat promosi layanan, tetapi juga memberikan pengalaman psikologis yang ringan, relevan, dan aplikatif. Misalnya melalui mini psychological check-up, konsultasi singkat, permainan atau aktivitas reflektif, edukasi mengenai tumbuh kembang dan kesehatan mental, serta informasi mengenai pilihan layanan yang dapat diakses pengunjung. Pendekatan ini selaras dengan visi Serasa Djiwa untuk mendukung kesejahteraan, pengembangan diri, dan kualitas hidup melalui layanan yang berlandaskan kemanusiaan, empati, dan kolaborasi.\nDengan demikian, pameran Serasa Djiwa dapat menjadi ruang untuk “mengenal diri, memahami kebutuhan, dan menemukan langkah perubahan”, sekaligus memperkenalkan Serasa Djiwa sebagai partner psikologis yang hadir untuk berbagai tahap kehidupan.",
        "tags": [
            "Jasa",
            "Startup",
            "Transaksi Booth"
        ],
        "logo": "https://canva.link/8iln2gko7k79ndd",
        "contact": "serasadjiwa21@gmail.com",
        "whatsapp": "+62 856-4514-5191",
        "web": "",
        "instagram": "@serasadjiwa",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "f6",
        "booth_no": 56,
        "code": "F6",
        "cluster": 4,
        "area": "F",
        "name": "Rexgo.Technology",
        "instansi": "Rexgo.Technology",
        "pic": "INDRA BAYU PURWANTORO",
        "cat": "Edutech",
        "desc": "REXGO adalah perusahaan teknologi interaktif yang menciptakan pengalaman digital untuk event, pameran, ritel, pendidikan, pariwisata, dan brand activation. Kami menggabungkan teknologi dan kreativitas untuk meningkatkan engagement audiens.",
        "tags": [
            "Edutech",
            "Startup",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/rexgo.png",
        "contact": "rexgotech@gmail.com",
        "whatsapp": "081217260020",
        "web": "https://www.rexgotech.com",
        "instagram": "@rexgo.tech",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "f7",
        "booth_no": 57,
        "code": "F7",
        "cluster": 4,
        "area": "F",
        "name": "Azura Umroh Private",
        "instansi": "Startup",
        "pic": "Venti",
        "cat": "Jasa",
        "desc": "Azura menemani perjalanan ibadah umroh secara private dan prioritas dengan hotel dekat masjid, mobil pribadi dan muthawif pribadi.",
        "tags": [
            "Jasa",
            "Startup",
            "Transaksi Booth"
        ],
        "logo": "https://lh3.googleusercontent.com/d/1XmUIE1ZdFZmjd-BhLkRAgNIDczYXVTuZ",
        "contact": "vechoirunnisa10@gmail.com",
        "whatsapp": "085161377131",
        "web": "",
        "instagram": "https://www.instagram.com/azura.umrohprivate?igsh=MTBoMHVpZGZhcXRhYg==",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "f8",
        "booth_no": 58,
        "code": "F8",
        "cluster": 4,
        "area": "F",
        "name": "Lokasi Nusantara Tour and Travel",
        "instansi": "Startup",
        "pic": "Aura Putricia Mahardini",
        "cat": "Jasa",
        "desc": "Lokasi Nusantara adalah pelopor jasa open & private trip berbasis penyembuhan jiwa dan keakraban komunitas. Menghadirkan wisata alam bernilai tinggi yang ramah waktu ibadah, fleksibel, serta mendukung keberdayaan UMKM lokal secara nyata.",
        "tags": [
            "Jasa",
            "Startup",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/lokasi_nusantara.png",
        "contact": "auramahardini@gmail.com",
        "whatsapp": "081230498086",
        "web": "",
        "instagram": "@lokasi.nusantara",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "f9",
        "booth_no": 59,
        "code": "F9",
        "cluster": 4,
        "area": "F",
        "name": "Japonindo Yotsuba",
        "instansi": "Japonindo Yotsuba",
        "pic": "Arif Fatchur Rochmaniyah",
        "cat": "Edutech",
        "desc": "Kursus Bahasa Jepang untuk membantu peserta menguasai Bahasa Jepang secara praktris, komunikatif, dan menyenangkan sesuai dengan moto kami itsudemo, dokodemo manabou!",
        "tags": [
            "Edutech",
            "Startup",
            "Transaksi Booth"
        ],
        "logo": "https://drive.google.com/drive/folders/1yZMU_fzmo1Dl19g2l4AC0nR4UJ6IXMNc?usp=sharing",
        "contact": "arifrahmania11@gmail.com",
        "whatsapp": "08563185856",
        "web": "",
        "instagram": "japonindo.yotsuba",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "f10",
        "booth_no": 60,
        "code": "F10",
        "cluster": 4,
        "area": "F",
        "name": "Tempat Tumbuh",
        "instansi": "PT Inspirasi Keuangan Syariah",
        "pic": "Saif Ali Khan",
        "cat": "Jasa",
        "desc": "Tempat Tumbuh merupakan platform pembelajaran keuangan yang membantu individu memahami konsep perencanaan dan pengelolaan keuangan, cara menyusun, beserta strategi implementasi dalam kehidupan sehari-hari secara lebih terarah dan terstruktur. Kami hadir bukan hanya sebagai platform edukasi, melainkan ekosistem pembelajaran yang berkomitmen membantu masyarakat Indonesia membangun perilaku finansial yang lebih sehat, disiplin, dan berkelanjutan. Berdiri sejak tahun 2025, Tempat Tumbuh telah menjalin\nkolaborasi strategis dengan beberapa mitra, mulai dari lembaga pendidikan, pelatihan, konsultasi, dan sertifikasi keuangan, lembaga pemberdayaan karir, hingga komunitas pengembangan diri. Kehadiran mitra strategis ini memperkuat langkah kami dalam membangun ekosistem pembelajaran keuangan yang inklusif dan berkelanjutan bagi masyarakat Indonesia.",
        "tags": [
            "Jasa",
            "Startup",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/tempat_tumbuh.png",
        "contact": "imondeskhan@gmail.com",
        "whatsapp": "089603446997",
        "web": "https://ptiksh.com/",
        "instagram": "tempattumbuh_edu",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "f11",
        "booth_no": 61,
        "code": "F11",
        "cluster": 4,
        "area": "F",
        "name": "FastrackEdu",
        "instansi": "Fastrack Edu Tenant Binaan Atavi Unair",
        "pic": "Khoirotul Amaliyah",
        "cat": "Jasa",
        "desc": "FastrackEdu hadir sebagai ekosistem pembelajaran digital terdepan yang dirancang khusus untuk membekali mahasiswa dengan keterampilan esensial dalam bidang riset dan penulisan ilmiah. Melalui integrasi pendekatan berbasis teknologi mutakhir serta bimbingan intensif dari para ahli, platform ini memastikan setiap mahasiswa mampu menghasilkan karya yang kredibel dan berkualitas.",
        "tags": [
            "Jasa",
            "Startup",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/fastrackedu.png",
        "contact": "abdulzidan118@gmail.com",
        "whatsapp": "085748828183",
        "web": "https://fastrackedu.id/",
        "instagram": "https://www.instagram.com/fastrackedu.official/",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "f12",
        "booth_no": 62,
        "code": "F12",
        "cluster": 4,
        "area": "F",
        "name": "Vitalic Hit Trigger Drum",
        "instansi": "PASINBIS",
        "pic": "FAISHAL AZKA CAHYO ANGGONO",
        "cat": "Edutech",
        "desc": "Vitalic Hit Trigger Drum adalah perangkat sensor elektronik buatan lokal Indonesia yang dipasang pada drum akustik untuk mengubah getaran pukulan menjadi sinyal suara digital atau elektrik",
        "tags": [
            "Edutech",
            "Startup",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/vitalic.png",
        "contact": "vitalichittrigger@gmail.com",
        "whatsapp": "081358502672",
        "web": "https://www.vitalichittrigger.com",
        "instagram": "vitalic.hit_footrix",
        "facebook": "Vitalic Hit Trigger",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "f13",
        "booth_no": 63,
        "code": "F13",
        "cluster": 4,
        "area": "F",
        "name": "KONVETO",
        "instansi": "Konveto (SERAGAMKANAKSIMU)",
        "pic": "Ardian",
        "cat": "Craft",
        "desc": "Konveto startup yang bergerak di bidang jasa konveksi seragam",
        "tags": [
            "Craft",
            "Startup",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/konveto.png",
        "contact": "konvetosurabaya@gmail.com",
        "whatsapp": "08993672913",
        "web": "",
        "instagram": "@Konveto.id",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "f14",
        "booth_no": 64,
        "code": "F14",
        "cluster": 4,
        "area": "F",
        "name": "HEZTEK CODING",
        "instansi": "Inkubator Bisnis ATAVI UNAIR",
        "pic": "Heni Prasetyorini, S.Si., M.Pd",
        "cat": "Edutech",
        "desc": "Ayo bermain, belajar, dan bikin project seru dengan coding bersama teman, orang tua, dan guru di Heztek Coding.",
        "tags": [
            "Edutech",
            "Startup",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/heztek.png",
        "contact": "heztekcoding@gmail.com",
        "whatsapp": "089699264015",
        "web": "https://www.heztekcoding.com/",
        "instagram": "https://www.instagram.com/heztekcoding/",
        "facebook": "https://www.facebook.com/heztekcoding/",
        "twitter": "https://www.threads.com/@heztekcoding?hl=id",
        "transaksi": "Ya",
        "desk": "HEZTEK CODING adalah tenant startup teknologi edukasi coding dan robotika untuk anak dan remaja yang dibina oleh inkubator bisnis ATAVI UNAIR sejak 2021."
    },
    {
        "id": "f15",
        "booth_no": 65,
        "code": "F15",
        "cluster": 4,
        "area": "F",
        "name": "Braja Elektrik X Renergy",
        "instansi": "Braja Elektrik X Renergy",
        "pic": "Uta",
        "cat": "Manufaktur",
        "desc": "Startup ekosistem kendaraan listrik dan konversi",
        "tags": [
            "Manufaktur",
            "Startup",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/braja_elektrik.png",
        "contact": "brajaelektrikmotor@gmail.com",
        "whatsapp": "082133881104",
        "web": "https://www.brajaelektrikmotor.com",
        "instagram": "Braja Elektrik Motor",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "f16",
        "booth_no": 66,
        "code": "F16",
        "cluster": 4,
        "area": "F",
        "name": "Sriwijaya Kontraktor",
        "instansi": "PT SRIWIJAYA KONTRAKTOR",
        "pic": "Bapak Firdaus",
        "cat": "Manufaktur",
        "desc": "Kami adalah perusahaan jasa konstruksi dan pembangunan yang melayani proyek rumah satu atau dua lantai. Kami juga menyediakan jasa desain 2D dan 3D untuk seluruh wilayah di Indonesia. Adapun pembangunan fisik mencakup area Jawa, Bali dan Jabodetabek",
        "tags": [
            "Manufaktur",
            "Startup",
            "Transaksi Booth"
        ],
        "logo": "https://sriwijayakontraktor.com/",
        "contact": "al.firdaus.work@gmail.com",
        "whatsapp": "082228520581",
        "web": "https://sriwijayakontraktor.com",
        "instagram": "sriwijaya kontraktor",
        "facebook": "Sriwijaya Kontraktor",
        "twitter": "Sriwijaya Kontraktor",
        "transaksi": "Ya"
    },
    {
        "id": "f17",
        "booth_no": 67,
        "code": "F17",
        "cluster": 4,
        "area": "F",
        "name": "APPA TECH",
        "instansi": "APPA TECH",
        "pic": "Razan Mahrani",
        "cat": "Jasa",
        "desc": "Perusahaan yang bergerak di bidang inovasi teknologi, khususnya kecerdasan buatan. Saat ini berfokus pada industri olahraga dan perkantoran",
        "tags": [
            "Jasa",
            "Startup",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/appa_tech.png",
        "contact": "razanmahrani@gmail.com",
        "whatsapp": "085730394996",
        "web": "https://grahateknologimaju.com/en",
        "instagram": "academyappa",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "f18",
        "booth_no": 68,
        "code": "F18",
        "cluster": 4,
        "area": "F",
        "name": "Likur Production",
        "instansi": "Airlangga Startup and Innovation Incubator (ATAVI)",
        "pic": "Reyhan Agung Ramadhan",
        "cat": "Jasa",
        "desc": "LIKUR Production is a Creative & Documentary Production House based in Surabaya, founded in 2022. Inspired by the Javanese philosophy “Linggih Kursi”, a symbol of leadership and independence. Likur embodies the spirit of young creators stepping into their own seat of responsibility: leading, collaborating, and shaping the future through storytelling.\n\nWe aspire to become Nusantara’s storyteller, bringing cultural heritage, local values, health, and eco-conscious into the modern era through timeless creative content.",
        "tags": [
            "Jasa",
            "Startup",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/likur.png",
        "contact": "likurproduction@gmail.com",
        "whatsapp": "085161328874",
        "web": "https://likur.id",
        "instagram": "@likurproduction",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "g1",
        "booth_no": 73,
        "code": "G1",
        "cluster": 5,
        "area": "G",
        "name": "Deorans",
        "instansi": "Universitas Airlangga",
        "pic": "Raihan Syah Rafi'",
        "cat": "Kuliner & Bisnis",
        "desc": "Deorans adalah deodoran alami berbahan mineral yang efektif melawan bau badan tanpa menghambat keringat. Aman, praktis, dan ramah kulit, Deorans hadir sebagai pilihan sehat untuk aktivitas sehari-hari.",
        "tags": [
            "Kuliner & Bisnis",
            "F&B",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/deorans.png",
        "contact": "deoransspray@gmail.com",
        "whatsapp": "082132529584",
        "web": "https://heylink.me/deorans",
        "instagram": "@deoransspray",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "g2",
        "booth_no": 74,
        "code": "G2",
        "cluster": 5,
        "area": "G",
        "name": "Tawdeo",
        "instansi": "Tawdeo",
        "pic": "Dela R G",
        "cat": "Kesehatan & Farmasi",
        "desc": "Tawdeo — Natural Care, Better for You & Earth\n\nTawdeo hadir sebagai brand personal care yang mengembangkan produk berbahan alami dengan mengutamakan manfaat, kenyamanan, dan kepedulian terhadap lingkungan. Dari perawatan tubuh hingga produk sehari-hari, Tawdeo ingin menghadirkan pilihan yang lebih bijak dan baik untuk diri sendiri maupun bumi.",
        "tags": [
            "Kesehatan & Farmasi",
            "F&B",
            "Transaksi Booth"
        ],
        "logo": "https://canva.link/3hu3b3qr4623vm5",
        "contact": "tawdeonatural@gmail.com",
        "whatsapp": "085179771295",
        "web": "",
        "instagram": "",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "g3",
        "booth_no": 75,
        "code": "G3",
        "cluster": 5,
        "area": "G",
        "name": "Partner SEHATin",
        "instansi": "Partner SEHATin",
        "pic": "Ira Nurwahyu Kusuma",
        "cat": "Kesehatan & Farmasi",
        "desc": "Partner SEHATin adalah platform kesehatan keluarga terpadu yang hadir untuk meningkatkan akses masyarakat terhadap informasi dan layanan kesehatan yang edukatif, interaktif, dan mudah dijangkau. Partner SEHATin mendampingi masyarakat dalam perjalanan kesehatan sejak masa remaja, persiapan pernikahan, kehamilan, hingga peran sebagai orang tua.\n\nMelalui layanan edukasi kesehatan, Partner SEHATin menyediakan informasi terpercaya mengenai kesehatan reproduksi, persiapan pranikah termasuk pre-marital check-up, kehamilan, serta penerapan pola hidup sehat bagi keluarga. Partner SEHATin juga menghadirkan ruang diskusi dan konsultasi yang memungkinkan pengguna bertanya dan memperoleh pendampingan terkait berbagai permasalahan kesehatan secara komunikatif dan mudah dipahami.\n\nUntuk memperluas akses, Partner SEHATin mengintegrasikan pengguna dengan berbagai layanan kesehatan dan produk pendukung melalui platform digital. Dengan pendekatan yang fleksibel, terjangkau, dan terintegrasi, Partner SEHATin berkomitmen menjadi mitra kesehatan keluarga yang mendampingi setiap tahap kehidupan, sekaligus mendorong masyarakat untuk lebih sadar, mandiri, dan proaktif dalam menjaga kesehatan.",
        "tags": [
            "Kesehatan & Farmasi",
            "F&B",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/partner_sehatin.png",
        "contact": "ira.nurwahyu@gmail.com",
        "whatsapp": "081232938578",
        "web": "",
        "instagram": "@partner.sehatin.id",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "g4",
        "booth_no": 76,
        "code": "G4",
        "cluster": 5,
        "area": "G",
        "name": "Sweetfood",
        "instansi": "Universitas Airlangga",
        "pic": "Eka Nur Lita",
        "cat": "Food & Beverage",
        "desc": "Sweetfood merupakan bisnis yang bergerak dibidang FnB yang berdiri sejak tahun 2023. Kami hadir membawa solusi atas masalah anda terkait \"Dream Cake\" pada hari special customer. Kami menawarkan cake dengan beberapa varian rasa, ukuran, dan desain yang dapat di custome sesuai kebutuhan customer dengan deadline waktu yang singkat dan jaminan pengiriman tepat waktu.\nKami menggunakan bahan-bahan berkualitas dengan proses produksi homemade sehingga cake terjaga kualitas dan cita rasanya.\nSweetfood telah bekerjasama dengan beberapa brand dan mendapatkan kepercayaan dari para customer melalui ribuan review positif serta loyalitas pelanggan. \n\nTagline sweetfood \"Timely, Affordable, and Reliable to Make Your Dream Cake Come True\"",
        "tags": [
            "Food & Beverage",
            "F&B",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/sweetfood.png",
        "contact": "ekanurlt25@gmail.com",
        "whatsapp": "082326116698",
        "web": "",
        "instagram": "https://www.instagram.com/sweetfood_id_?igsh=Y3YyZjd1cHIwcGdm",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "g5",
        "booth_no": 77,
        "code": "G5",
        "cluster": 5,
        "area": "G",
        "name": "GOLDEN GATE DIMSUM",
        "instansi": "Golden Gate Dimsum x Mengoba-tea",
        "pic": "Adinda Vidya Lestari",
        "cat": "Food & Beverage",
        "desc": "Golden Gate Dimsum x Mengoba-tea merupakan Business yang bergerak di bidang FnB dengan niche yaitu healthy Food and Beverages yang bisa menjadi bahan baku maupun ready to eat. Kami menyajikan bentuk frozen dengan kemasan bulk maupun siap saji. Bahan yang kami gunakan premium dan bebas msg sehingga penyimpanan setelah dibuka hanya sampai 3 bulan untuk memastikan mutu produk. Dengan terus berinovasi kami berharap bisa menciptakan produk yang berdaya saing tinggi dengan pengembangan teknologi yang lebih modern",
        "tags": [
            "Food & Beverage",
            "F&B",
            "Transaksi Booth"
        ],
        "logo": "https://canva.link/rpy259ds74snjea",
        "contact": "adindavidya01@gmail.com",
        "whatsapp": "082220809000",
        "web": "",
        "instagram": "@goldengatedimsum",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "g6",
        "booth_no": 78,
        "code": "G6",
        "cluster": 5,
        "area": "G",
        "name": "lammaqbanna",
        "instansi": "The Homemade",
        "pic": "gusti",
        "cat": "Food & Beverage",
        "desc": "LAMMAQBANNA adalah startup binaan unair, bergerak dibidang seasoning dan snack, berlegalitas nib, pirt, halal dan terdaftar merk. kami juga peduli tentang sustainability diantaranya mengurangi foodwaste, produkkaldu bubuk kami mengusung konsep less waste, beberapa dari hasil penjualan untuk mendanai program intern dari kami yaitu \"RING\" sharing for caring, dengan membagikan hasil masakan dari dapur kami dan memakai bumbu dari hasil produksi kami.",
        "tags": [
            "Food & Beverage",
            "F&B",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/lammaqbanna.png",
        "contact": "lovellyemma48@gmail.com",
        "whatsapp": "081331114215",
        "web": "https://s.id/thehomemade899",
        "instagram": "Thehomemade899",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "g7",
        "booth_no": 79,
        "code": "G7",
        "cluster": 5,
        "area": "G",
        "name": "Ayam ungkep teh nisa",
        "instansi": "Inkubator unair",
        "pic": "Nisa Nurrohmah",
        "cat": "Food & Beverage",
        "desc": "Memproduksi ayam dan bebek siap goreng lengkap dengan sambal dalam kemasan vakum pack",
        "tags": [
            "Food & Beverage",
            "F&B",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/ayam_teh_nisa.png",
        "contact": "nisasby777@gmail.com",
        "whatsapp": "081522979766",
        "web": "",
        "instagram": "Ayam ungkep teh nisa",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "g8",
        "booth_no": 80,
        "code": "G8",
        "cluster": 5,
        "area": "G",
        "name": "Sahabat Spondan",
        "instansi": "Sahabat Spondan",
        "pic": "AMRETA LARAS PERTIWI",
        "cat": "PGN",
        "desc": "Produk olahan siap saji yang menemani setiap kegiatanmu menjadi lebih berwarna. Menghadirkan cita rasa otentik dengan harga terjangkau yang dikemas dan disajikan dengan rasa cinta. Setiap gigitan menciptakan kehangatan dalam setiap kegiatan bersama teman, keluarga dan orang tersayang kamu.",
        "tags": [
            "PGN",
            "F&B",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/sahabat_spondan.png",
        "contact": "amretapertiwi3@gmail.com",
        "whatsapp": "085730171516",
        "web": "",
        "instagram": "https://www.instagram.com/sahabatspondan_sby?igsh=MTU1bzBzZXl1cHEzcQ==",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "h1",
        "booth_no": 81,
        "code": "H1",
        "cluster": 6,
        "area": "H",
        "name": "Gyarus Indonesia",
        "instansi": "CV Gyarus Indonesia Group",
        "pic": "Firdayanti Zahro",
        "cat": "Fashion",
        "desc": "Gyarus adalah brand lokal asal Surabaya yang bergerak di bidang fashion muslim, khususnya menghadirkan mukenah dengan desain yang nyaman, elegan, dan relevan dengan kebutuhan perempuan modern serta bisa custom  design. \n\nDalam perkembangannya, Gyarus tidak hanya melayani kebutuhan konsumen secara retail, tetapi juga telah dipercaya untuk berkolaborasi dengan berbagai instansi dalam penyediaan gift dan merchandise, menjadikan produk Gyarus sebagai pilihan untuk kebutuhan personal maupun corporate gifting.\n\nDengan mengutamakan kualitas produk, desain yang menarik dan available custom design, Gyarus terus mengembangkan diri sebagai brand fashion lokal yang mampu menghadirkan produk bernilai guna sekaligus berkesan.",
        "tags": [
            "Fashion",
            "Kreatif",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/gyarus.png",
        "contact": "firdayantizahro27@gmail.com",
        "whatsapp": "0877-0451-9225",
        "web": "",
        "instagram": "https://www.instagram.com/gyarus.id?igsh=MTk1N3Q0c3ZocjM0dA%3D%3D&utm_source=qr",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "h2",
        "booth_no": 82,
        "code": "H2",
        "cluster": 6,
        "area": "H",
        "name": "Leastra",
        "instansi": "Leastra",
        "pic": "Adelia Permatasari",
        "cat": "Craft",
        "desc": "Leastra merupakan brand yang menjual aksesoris seperti dompet,lanyard dan card holder menggunakan kulit sapi dengan perpaduan batik. visi kami ialah menyejahterahkan pengrajin lokal dan membudidayakan penggunaan kain batik pada kehidupan sehari-hari",
        "tags": [
            "Craft",
            "Kreatif",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/leastra.png",
        "contact": "adeliassari@gmail.com",
        "whatsapp": "081334331982",
        "web": "",
        "instagram": "@leastra.id",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "h3",
        "booth_no": 83,
        "code": "H3",
        "cluster": 6,
        "area": "H",
        "name": "Tjakrawala Batik & Crafts",
        "instansi": "Tjakrawala Batik & Crafts",
        "pic": "Azza Nur Fadilah",
        "cat": "Fashion",
        "desc": "Tjakrawala Batik & Crafts adalah rumah batik yang berfokus pada batik tulis khas Madura dan aneka kerajinan anyaman dari daun agel. Kami memproduksi berbagai macam batik tulis dengan motif tradisional dan kontemporer, serta memanfaatkan perca kain batik dan daun agel untuk menciptakan produk fashion dan home decor yang unik dan berkelanjutan.",
        "tags": [
            "Fashion",
            "Kreatif",
            "Transaksi Booth"
        ],
        "logo": "https://lh3.googleusercontent.com/d/1zgr3Mof7v_fwd7RFdGc6vdLrd8obiHd9",
        "contact": "azzafadilah14@gmail.com",
        "whatsapp": "087850720142",
        "web": "https://www.tjakrawalabatik.com",
        "instagram": "https://www.instagram.com/tjakrawala_batik/",
        "facebook": "https://web.facebook.com/people/Tjakrawala-Batik-Crafts/61564244136391/?_rdc=10&_rdr",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "h4",
        "booth_no": 84,
        "code": "H4",
        "cluster": 6,
        "area": "H",
        "name": "Botega Indonesia",
        "instansi": "Botega Indonesia",
        "pic": "Evelyn Wijaya",
        "cat": "Craft",
        "desc": "Botega is a wellness brand creating sensory experiences through candles, soaps, perfumes, massage oils, and reed diffusers. We support emotional well-being, encourage self-care, and empower women through meaningful products and positive impact.",
        "tags": [
            "Craft",
            "Kreatif",
            "Transaksi Booth"
        ],
        "logo": "",
        "contact": "Evelinnewijaya@gmail.com",
        "whatsapp": "081333309993",
        "web": "",
        "instagram": "@botega.id",
        "facebook": "Botega Indonesia",
        "twitter": "",
        "transaksi": "Ya",
        "desk": "Botega Indonesia adalah brand wellness yang menghadirkan pengalaman sensorik melalui produk aromatik berkualitas, mulai dari lilin aromaterapi, sabun, parfum, minyak pijat, hingga reed diffuser untuk mendukung relaksasi dan self-care."
    },
    {
        "id": "h5",
        "booth_no": 85,
        "code": "H5",
        "cluster": 6,
        "area": "H",
        "name": "allbouquets",
        "instansi": "PASINBIS Universitas Airlangga",
        "pic": "Alfi Laili Azizah",
        "cat": "Craft",
        "desc": "Allbouquets — buket bunga handmade custom sesuai tema & budget. Cocok untuk hadiah personal, wisuda, hingga gift event. Harga terjangkau, kualitas estetik, free ongkir via Shopee. Let's Celebrate Special Day with Special Bouquets! 🌸",
        "tags": [
            "Craft",
            "Kreatif",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/allbouquets.png",
        "contact": "allbouquets12@gmail.com",
        "whatsapp": "085749884741",
        "web": "",
        "instagram": "https://www.instagram.com/allbouquets/",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "h6",
        "booth_no": 86,
        "code": "H6",
        "cluster": 6,
        "area": "H",
        "name": "Etnapraya",
        "instansi": "Etnapraya",
        "pic": "Etty Ariaty Soraya",
        "cat": "Craft",
        "desc": "Etnapraya adalah merek tas lokal Indonesia yang menggabungkan keindahan budaya dan keahlian dalam setiap produknya. Setiap tas dibuat dari kulit asli berkualitas tinggi dihiasi dengan motif batik yang didesain ulang dengan indah, memadukan tradisi abadi dengan sentuhan desain modern.",
        "tags": [
            "Craft",
            "Kreatif",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/etnapraya.png",
        "contact": "etnapraya@gmail.com",
        "whatsapp": "+62 823-3819-1372",
        "web": "https://etnapraya.com",
        "instagram": "Etnapraya",
        "facebook": "Etnapraya",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "h7",
        "booth_no": 87,
        "code": "H7",
        "cluster": 6,
        "area": "H",
        "name": "Quoversity",
        "instansi": "QUOVERSITY",
        "pic": "Muhammad Akbar Zulkarnain",
        "cat": "Craft",
        "desc": "Quoversity adalah brand merchandise yang mengangkat quote dan pemikiran guru besar serta akademisi ke dalam desain kaos. Menggabungkan intelektualitas, kreativitas, dan gaya, Quoversity menjadikan gagasan akademik sebagai bagian dari identitas dan keseharian.",
        "tags": [
            "Craft",
            "Kreatif",
            "Transaksi Booth"
        ],
        "logo": "",
        "contact": "akbarzulkarnain2303@gmail.com",
        "whatsapp": "085107733888",
        "web": "",
        "instagram": "",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "h10",
        "booth_no": 90,
        "code": "H10",
        "cluster": 6,
        "area": "H",
        "name": "AineMeara",
        "instansi": "-",
        "pic": "Neina",
        "cat": "Fashion",
        "desc": "Ainemeara menyediakan beragam produk kerajinan tangan diantaranya bouquet & hampers hijab serta artificial flowers dengan pengiriman ke seluruh wilayah Indonesia",
        "tags": [
            "Fashion",
            "Kreatif",
            "Transaksi Booth"
        ],
        "logo": "https://drive.google.com/drive/folders/12gH6jh1EaibV_DayJiJn8dzNg928eNcS",
        "contact": "ainemeara@gmail.com",
        "whatsapp": "082337701988",
        "web": "",
        "instagram": "https://www.instagram.com/ainemeara?igsh=MTZqb3Y1OGdkazNxOA==",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "h11",
        "booth_no": 91,
        "code": "H11",
        "cluster": 6,
        "area": "H",
        "name": "Anka Mini Lab",
        "instansi": "PASINBIS Universitas Airlangga",
        "pic": "Alify Yanura",
        "cat": "Craft",
        "desc": "Sabun dari bahan natural dan dibuat  handmade. Mampu memberikan perlindungan alami bagi kulit. Ramah dan aman bagi kulit sensitif",
        "tags": [
            "Craft",
            "Kreatif",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/anka_minilab.png",
        "contact": "alifyayp@gmail.com",
        "whatsapp": "085755165911",
        "web": "",
        "instagram": "ankaminilab",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "h12",
        "booth_no": 92,
        "code": "H12",
        "cluster": 6,
        "area": "H",
        "name": "ByLaw Nails",
        "instansi": "Universitas Airlangga",
        "pic": "Glorya Angela",
        "cat": "Craft",
        "desc": "ByLaw.Nails adalah brand kecantikan lokal yang bergerak di bidang press-on nails dengan menghadirkan produk kuku siap pakai yang praktis, reusable, customizable, dan stylish. ByLaw.Nails hadir sebagai solusi bagi konsumen yang ingin memiliki tampilan kuku yang cantik dan fashionable tanpa harus menghabiskan banyak waktu dan biaya untuk melakukan perawatan kuku di salon.\n\nByLaw.Nails menawarkan berbagai pilihan desain mulai dari desain minimalis, elegan, cute, hingga karakter dan tren populer yang dapat disesuaikan dengan preferensi pelanggan. Selain pilihan desain yang tersedia, pelanggan juga dapat melakukan custom order untuk menciptakan press-on nails yang lebih personal dan sesuai dengan karakter maupun kebutuhan mereka.\n\nDengan mengutamakan kualitas produk dan pengalaman pelanggan, setiap press-on nails dibuat melalui proses produksi yang memperhatikan detail, kerapian, dan estetika. Produk juga dirancang agar dapat digunakan kembali dengan perawatan yang tepat, sehingga memberikan nilai lebih bagi konsumen sekaligus mendukung penggunaan produk yang lebih berkelanjutan.\n\nByLaw.Nails menargetkan pasar Gen Z dan konsumen muda, khususnya mereka yang memiliki gaya hidup aktif, mengikuti tren kecantikan, dan menginginkan produk beauty yang praktis serta affordable. Pemasaran dilakukan secara digital melalui berbagai platform seperti TikTok, Instagram, dan Shopee untuk menjangkau konsumen secara lebih luas.\nKe depannya, ByLaw.Nails berkomitmen untuk terus mengembangkan inovasi produk, meningkatkan kualitas pelayanan, memperluas jangkauan pasar, serta membangun ekosistem bisnis kecantikan yang kreatif dan relevan dengan perkembangan tren. Dengan menggabungkan kreativitas, kualitas, dan kemudahan, ByLaw.Nails ingin menjadi salah satu brand press-on nails lokal yang dipercaya dan menjadi pilihan utama konsumen.",
        "tags": [
            "Craft",
            "Kreatif",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/bylaw_nails.png",
        "contact": "glorya.angela.marshanda-2023@feb.unair.ac.id",
        "whatsapp": "08115755656",
        "web": "",
        "instagram": "https://www.instagram.com/bylaw.nails/",
        "facebook": "",
        "twitter": "https://www.instagram.com/bylaw.nails/",
        "transaksi": "Ya"
    },
    {
        "id": "h13",
        "booth_no": 93,
        "code": "H13",
        "cluster": 6,
        "area": "H",
        "name": "Studi Inkubator MUA",
        "instansi": "Studi Inkubator MUA",
        "pic": "Treesya",
        "cat": "Jasa",
        "desc": "Merupakan badan usaha yang menaungi komunitas para Makeup Artist di Surabaya untuk memberikan jasa layanan makeup yang profesional dan berkualitas",
        "tags": [
            "Jasa",
            "Kreatif",
            "Transaksi Booth"
        ],
        "logo": "https://canva.link/01bdnzrdocrhl0u",
        "contact": "tresyagirls@gmail.com",
        "whatsapp": "085708342811",
        "web": "",
        "instagram": "studioinkubatormua",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "h14",
        "booth_no": 94,
        "code": "H14",
        "cluster": 6,
        "area": "H",
        "name": "zarunagift",
        "instansi": "universitas airlangga",
        "pic": "Fito",
        "cat": "Craft",
        "desc": "Zaruna adalah brand yang bergerak di bidang gift, florist, dan custom souvenir yang menghadirkan berbagai produk untuk momen spesial seperti ulang tahun, wisuda, anniversary, hingga berbagai kebutuhan acara dan perusahaan.\n\nZaruna memiliki beberapa lini bisnis, yaitu Zaruna Florist untuk buket bunga dan karangan bunga, Zaruna Gift untuk produk custom dan souvenir, serta Zaruna Decoration untuk kebutuhan dekorasi acara.\n\nDengan mengutamakan kreativitas, personalisasi, harga yang terjangkau, dan pelayanan yang praktis, Zaruna membantu pelanggan menciptakan hadiah yang lebih personal dan berkesan. Pelanggan juga dapat melakukan custom desain sesuai kebutuhan tanpa harus terpaku pada produk yang sudah tersedia.\n\nZaruna berkomitmen untuk terus berinovasi dalam menghadirkan produk dan pengalaman yang relevan bagi generasi muda maupun kebutuhan bisnis, dengan semangat “We don’t just sell gifts, we deliver emotions.”",
        "tags": [
            "Craft",
            "Kreatif",
            "Transaksi Booth"
        ],
        "logo": "https://id.shp.ee/SHug2F2W",
        "contact": "fito.fitroh1@gmail.com",
        "whatsapp": "089513370904",
        "web": "http://msha.ke/zarunagift",
        "instagram": "zaruna.gift",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "b1",
        "booth_no": 97,
        "code": "B1",
        "cluster": 7,
        "area": "B",
        "name": "Airlangga University Press (P3UA)",
        "instansi": "Airlangga University Press (P3UA)",
        "pic": "Sarah Khairunnisa",
        "cat": "Internal UNAIR",
        "desc": "Airlangga University Press (AUP) merupakan penerbit resmi Universitas Airlangga yang berkomitmen pada penerbitan akademik dan ilmiah yang berintegritas, profesional, dan berdaya saing global. Dengan menerbitkan buku akademik dari berbagai disiplin ilmu sebagai sarana diseminasi pengetahuan bagi sivitas akademika dan komunitas nasional maupun internasional.",
        "tags": [
            "Internal UNAIR",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/p3ua.png",
        "contact": "sarah.khairunnisa@staf.unair.ac.id",
        "whatsapp": "085607811921",
        "web": "https://omp.unair.ac.id",
        "instagram": "aupunair.official",
        "facebook": "https://www.facebook.com/airlangga.press/",
        "twitter": "twitter.com/aup_unair",
        "transaksi": "Ya"
    },
    {
        "id": "b2",
        "booth_no": 98,
        "code": "B2",
        "cluster": 7,
        "area": "B",
        "name": "Pusat Penelitian Stem Cell dan Kedokteran Regeneratif",
        "instansi": "Pusat Penelitian Stem Cell dan Kedokteran Regeneratif",
        "pic": "Asa Ardiana",
        "cat": "Internal UNAIR",
        "desc": "Laboratorium kami menyediakan informasi mengenai penelitian, program magang, produk turunan stem cell, serta konsultasi dan kolaborasi di bidang Stem Cell",
        "tags": [
            "Internal UNAIR",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/stem_cell.png",
        "contact": "stemcell@itd.unair.ac.id",
        "whatsapp": "081325573848",
        "web": "https://www.stemcell.unair.ac.id",
        "instagram": "unair.stemcell",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "b3",
        "booth_no": 99,
        "code": "B3",
        "cluster": 7,
        "area": "B",
        "name": "PUI-PT RC-GERID",
        "instansi": "Universitas Airlangga",
        "pic": "Aisah Nur Ana Bilah",
        "cat": "Internal UNAIR",
        "desc": "Research Center for Global Emerging and Re-emerging Infectious Diseases (RC GERID) merupakan pusat riset yang berfokus pada pengembangan ilmu pengetahuan, teknologi, dan produk inovatif untuk menghadapi ancaman penyakit infeksi emerging dan re-emerging melalui integrasi epidemiologi, biologi molekuler, mikrobiologi, genomik, bioinformatika, dan kesehatan masyarakat. RC GERID mengembangkan penelitian berbasis molecular epidemiology dan genomic surveillance yang diarahkan tidak hanya untuk menghasilkan publikasi dan bukti ilmiah.",
        "tags": [
            "Internal UNAIR",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/rc_gerid.png",
        "contact": "aisahanabilah@gmail.com",
        "whatsapp": "085854006650",
        "web": "https://rc-gerid.unair.ac.id",
        "instagram": "https://www.instagram.com/rcgerid.unair/",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya",
        "desk": "Pusat Unggulan IPTEKS Perguruan Tinggi Research Center on Global Emerging and Re-emerging Infectious Diseases (RC-GERID), Universitas Airlangga."
    },
    {
        "id": "b4",
        "booth_no": 100,
        "code": "B4",
        "cluster": 7,
        "area": "B",
        "name": "PUI-PT Patient Safety & Quality",
        "instansi": "Universitas Airlangga",
        "pic": "Luckyta",
        "cat": "Internal UNAIR",
        "desc": "PUI-PT Center of Excellence for Patient Safety and Quality (PUI-PT CoE-PSQ) merupakan pusat unggulan Universitas Airlangga yang berfokus pada pengembangan mutu pelayanan dan keselamatan pasien melalui pendidikan, penelitian, dan advokasi.\n\nDalam booth ini, PUI-PT CoE-PSQ memperkenalkan berbagai produk dan layanan unggulan yang mendukung edukasi serta peningkatan keselamatan pasien, antara lain buku keselamatan pasien Jilid 1–3, buku cerita pasien dalam 6 seri, serta layanan konsultasi di bidang mutu dan keselamatan pasien. Selain itu, tersedia berbagai merchandise PUI-PT CoE-PSQ dengan identitas dan desain khusus, seperti payung, notebook, mug, dan tote bag.\n\nBerbagai produk dan layanan tersebut merupakan bagian dari upaya PUI-PT CoE-PSQ dalam menyebarluaskan pengetahuan, meningkatkan kesadaran mengenai keselamatan pasien, serta mendukung penerapan mutu dan keselamatan pasien di berbagai lingkungan pelayanan kesehatan.",
        "tags": [
            "Internal UNAIR",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/patient_safety.png",
        "contact": "prkp@unair.ac.id",
        "whatsapp": "085732939252",
        "web": "https://patientsafety.unair.ac.id",
        "instagram": "pusatrisetkeselamatanpasien",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya",
        "desk": "PUI-PT Center of Excellence for Patient Safety and Quality (Pusat Riset Keselamatan Pasien) Universitas Airlangga."
    },
    {
        "id": "b5",
        "booth_no": 101,
        "code": "B5",
        "cluster": 7,
        "area": "B",
        "name": "AILG Universitas Airlangga",
        "instansi": "Universitas Airlangga",
        "pic": "Nuzul Alya",
        "cat": "Internal UNAIR",
        "desc": "AILG adalah pusat unggulan yang didirikan oleh Universitas Airlangga untuk mendukung perkembangan profesional dan pribadi masyarakat luas. AILG membawahi 9 Center Unggulan Unair yang menawarkan berbagai program penelitian, kajian, konsultasi, pelatihan, dan workshop yang dirancang untuk memperluas pengetahuan serta keterampilan dalam berbagai bidang, mulai dari manajemen, teknologi informasi, sains hingga ilmu sosial.",
        "tags": [
            "Internal UNAIR",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/ailg.png",
        "contact": "ailg@unair.ac.id",
        "whatsapp": "085888991515",
        "web": "https://ailg.unair.ac.id",
        "instagram": "@ailg_unair",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya",
        "desk": "Airlangga Institute for Learning and Growth (AILG) Universitas Airlangga."
    },
    {
        "id": "b6",
        "booth_no": 102,
        "code": "B6",
        "cluster": 7,
        "area": "B",
        "name": "PUI-PT SCT",
        "instansi": "Fakultas Farmasi",
        "pic": "Prof. Tristiana Erawati Munandar, M.Si. Apt.",
        "cat": "Internal UNAIR",
        "desc": "PUI-PT Kesehatan Kulit dan Teknologi Kosmetik ( Skin and Cosmetic Technology (SCT) Centre of Excellent ) is a part of the Faculty of Pharmacy, Universitas Airlangga. This research group was founded for pharmaceutical sciences excellence. Main research of this research group are cosmetic delivery system and its evaluation to produce cosmetic preparations with quality standards and requirements (stable, effective, safe, and acceptable). The studies are anti-aging preparations, sunscreens, skincare, and hair extension. In the successful execution of its range of activities and services, the PUIPT-SCT organization necessitates and effectively leverages the power of information technology.",
        "tags": [
            "Internal UNAIR",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/sct_unair.png",
        "contact": "puipt-sct@ff.unair.ac.id",
        "whatsapp": "+62 812-1671-607",
        "web": "https://puiptsct.ff.unair.ac.id/",
        "instagram": "",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "b7",
        "booth_no": 103,
        "code": "B7",
        "cluster": 7,
        "area": "B",
        "name": "DPA Group",
        "instansi": "PT. Dharma Putra Airlangga",
        "pic": "Delfa Plezia",
        "cat": "Internal UNAIR",
        "desc": "Holding Company of Universitas Airlangga - Airlangga Global Travelling AGT), Inovasi Bioproduk Indonesia (Inobi), PT. Abhiseka Bangun Sarana, PT. Airlangga Univ Konsultan, PT. Dharma Putra Adigraha.",
        "tags": [
            "Internal UNAIR",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/dpa_group.png",
        "contact": "info@airlanggatravel.com / admin@dpacorp.id",
        "whatsapp": "+62 838-4636-3901",
        "web": "",
        "instagram": "https://www.instagram.com/dpa.corp",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "b8",
        "booth_no": 104,
        "code": "B8",
        "cluster": 7,
        "area": "B",
        "name": "Pemeriksaan Gigi Gratis RSGM UNAIR",
        "instansi": "RSGM UNAIR",
        "pic": "drg. Vankalayya Y. D",
        "cat": "Internal UNAIR",
        "desc": "RSGM UNAIR berpartisipasi dalam Industry Matching IM ASSIE IV 2026 sebagai wadah untuk memperkenalkan layanan, inovasi, dan pengembangan teknologi di bidang kesehatan gigi dan mulut serta membuka peluang kolaborasi strategis dengan berbagai pihak.",
        "tags": [
            "Internal UNAIR",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/rsgm.png",
        "contact": "adm@rsgm.unair.ac.id",
        "whatsapp": "081335158286",
        "web": "https://rsgm.unair.ac.id/",
        "instagram": "rsgmunair",
        "facebook": "RSGM UNAIR",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "b9",
        "booth_no": 105,
        "code": "B9",
        "cluster": 7,
        "area": "B",
        "name": "RSH Universitas Airlangga",
        "instansi": "Rumah Sakit Hewan Universitas Airlangga",
        "pic": "Abihilla Zikra Taim, drh",
        "cat": "Internal UNAIR",
        "desc": "Booth Rumah Sakit Hewan (RSH) Universitas Airlangga merupakan sarana edukasi dan informasi mengenai layanan kesehatan hewan yang disediakan oleh RSH UNAIR. Melalui booth ini, pengunjung dapat mengenal berbagai layanan, seperti pemeriksaan kesehatan, vaksinasi, konsultasi dokter hewan, tindakan medis, serta edukasi mengenai perawatan dan kesejahteraan hewan. Selain memperkenalkan fasilitas dan layanan, booth ini juga menjadi media untuk meningkatkan kesadaran masyarakat tentang pentingnya menjaga kesehatan hewan sebagai bagian dari kesehatan lingkungan. Dengan konsep yang informatif dan interaktif, Booth RSH Universitas Airlangga diharapkan dapat memberikan pengalaman edukatif sekaligus mempererat hubungan antara institusi, tenaga medis veteriner, dan masyarakat.",
        "tags": [
            "Internal UNAIR",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/rsh_unair.png",
        "contact": "abihilalzikra.taim@gmail.com",
        "whatsapp": "082186484622",
        "web": "https://www.rsh.unair.ac.id",
        "instagram": "rsh.unair",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    },
    {
        "id": "b10",
        "booth_no": 106,
        "code": "B10",
        "cluster": 7,
        "area": "B",
        "name": "Rumah Sakit Universitas Airlangga",
        "instansi": "Rumah Sakit Universitas Airlangga",
        "pic": "Prisma Andita Pebriaini, S.KM., M.Kes",
        "cat": "Internal UNAIR",
        "desc": "Rumah Sakit Universitas Airlangga sebagai academic teaching hospital, mengintegrasikan pendidikan, penelitian, dan layanan kesehatan unggul. Berorientasi pada pelayanan pasien, inovasi, kolaborasi internasional, serta pengembangan medical tourism.",
        "tags": [
            "Internal UNAIR",
            "Transaksi Booth"
        ],
        "logo": "assets/tenant-logos/rsua.png",
        "contact": "riset.rsua2019@gmail.com",
        "whatsapp": "085728059595",
        "web": "https://rumahsakit.unair.ac.id/",
        "instagram": "rs.unair",
        "facebook": "",
        "twitter": "",
        "transaksi": "Ya"
    }
],
    denahBaseImage: '',
    denahDefaultImage: '',
  };

  /* ══════════════════════════════════════════════════════
     MERGE dari ASSIE4_DB (injected via wp_add_inline_script)
     ═══════════════════════════════════════════════════════ */
  (function() {
    var db = window.ASSIE4_DB;
    if (!db) { return; }
    function normTenant(t) {
      var bNo = (t.booth_no !== undefined && t.booth_no !== null && t.booth_no !== '') ? parseInt(t.booth_no, 10) : '';
      var cde = t.code || (t.id ? String(t.id).toUpperCase() : '');
      var ara = t.area || (cde ? cde.charAt(0).toUpperCase() : 'A');
      return {
        id:        t.id || (cde ? cde.toLowerCase() : ''),
        booth_no:  bNo,
        code:      cde,
        cluster:   t.cluster || 1,
        area:      ara,
        name:      t.name || '',
        instansi:  t.instansi || '',
        pic:       t.pic || '',
        cat:       t.cat || '',
        desc:      t.desc || '',
        tags:      Array.isArray(t.tags) ? t.tags : (t.tags || '').split(',').map(function(s){return s.trim();}).filter(Boolean),
        logo:      t.logo || '',
        contact:   t.contact || '',
        whatsapp:  t.whatsapp || '',
        web:       t.web || '',
        instagram: t.instagram || '',
        facebook:  t.facebook || '',
        twitter:   t.twitter || '',
        transaksi: t.transaksi || ''
      };
    }
    if (db.info    && typeof db.info==='object')              DATA.info    = db.info;
    if (db.slides  && db.slides.length)                       DATA.slides  = db.slides;
    if (db.ticker  && db.ticker.length)                       DATA.ticker  = db.ticker;
    if (db.rundown && db.rundown.events && db.rundown.events.length) DATA.rundown = db.rundown;
    if (db.denah   && Array.isArray(db.denah))                DATA.denah   = db.denah;
    if (typeof db.denahBaseImage === 'string')                DATA.denahBaseImage = db.denahBaseImage;
    if (typeof db.denahDefaultImage === 'string')             DATA.denahDefaultImage = db.denahDefaultImage;
    if (db.tenants && Array.isArray(db.tenants) && db.tenants.length > 0) {
      DATA.tenants = db.tenants.map(normTenant);
    }
  })();

  /* ── HELPERS ── */
  function escH(s){return String(s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');}

  /* ══════════════════════════════════════════════════════
     CLOCK
     ═══════════════════════════════════════════════════════ */

  /* ══════════════════════════════════════════════════════
     NAV
     ═══════════════════════════════════════════════════════ */
  var navBtns = document.querySelectorAll('.a4-nb');
  window.a4ToggleMenu=function(force){
    var nav=document.getElementById('a4Nav'),button=document.querySelector('.a4-menu-toggle');
    if(!nav||!button)return;
    var open=typeof force==='boolean'?force:!nav.classList.contains('is-open');
    nav.classList.toggle('is-open',open);
    button.setAttribute('aria-expanded',open?'true':'false');
    button.setAttribute('aria-label',open?'Tutup menu navigasi':'Buka menu navigasi');
    button.innerHTML=uiIcon(open?'close':'menu');
  };
  window.a4GoTo = function(id){
    var el=document.getElementById(id);
    window.a4ToggleMenu(false);
    if(el) el.scrollIntoView({behavior:window.matchMedia('(prefers-reduced-motion: reduce)').matches?'auto':'smooth'});
    navBtns.forEach(function(b){b.classList.remove('on');});
    var a=document.querySelector('.a4-nb[onclick*="\''+id+'\'"]');
    if(a) a.classList.add('on');
  };

  /* ══════════════════════════════════════════════════════
     INFO STRIP
     ═══════════════════════════════════════════════════════ */
  function renderInfo(){
    var I=DATA.info;
    function s(id,v){var el=document.getElementById(id);if(el)el.textContent=v;}
    s('a4iDate',I.date||'—'); s('a4iLoc',I.location||'—'); s('a4iOrg',I.org||'—');
    s('a4iTime',(I.timeOpen||'08:00')+' – '+(I.timeClose||'20:00'));
  }

  /* ══════════════════════════════════════════════════════
     HERO SLIDER — support image URL background
     ═══════════════════════════════════════════════════════ */
  var reduceMotion=window.matchMedia('(prefers-reduced-motion: reduce)');
  var curSl=0, slTimer, slPaused=reduceMotion.matches, slHover=false;
  function uiIcon(name){return '<svg class="a4-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><use href="#a4-icon-'+name+'"></use></svg>';}
  function renderSlider(){
    var wrap=document.getElementById('a4SlWrap'), dots=document.getElementById('a4SlDots');
    if(!wrap||!dots) return;
    wrap.innerHTML=''; dots.innerHTML='';
    DATA.slides.forEach(function(s,i){
      var div=document.createElement('div');
      div.className='a4-sl'+(i===0?' on':'');
      div.setAttribute('aria-roledescription','slide');
      div.setAttribute('aria-label',(i+1)+' dari '+DATA.slides.length);
      div.setAttribute('aria-hidden',i===0?'false':'true');
      div.inert=i!==0;
      var bg=(Array.isArray(s.photos)&&s.photos[0])||s.bg||'';
      var isImg=/^https?:\/\//i.test(bg)||/\.(jpe?g|png|webp)/i.test(bg);
      var photo=document.createElement('div');
      photo.className='a4-sl-bg'+(isImg?' a4-sl-bg-img':'');
      if(isImg) photo.style.backgroundImage='url('+JSON.stringify(bg)+')';
      else photo.style.background=bg||'#080d1b';
      div.appendChild(photo);
      var logoSlide=s.is_logo||s.logo_only||(s.title&&s.title.trim().toLowerCase()==='industry matching');
      var lUrl=s.logo||((window.ASSIE4_CFG||{}).pluginUrl||'')+'assets/logo-assie4.png';
      var heading=logoSlide
        ? '<img class="a4-hero-brand" src="'+escH(lUrl)+'" alt="Industry Matching ASSIE IV 2026">'
        : '<'+(i===0?'h1':'h2')+' class="a4-sl-h1">'+escH(s.title||'ASSIE IV 2026')+'</'+(i===0?'h1':'h2')+'>';
      var link=s.link||'#denah';
      if(!/^(https?:\/\/|#|\/)/i.test(link)) link='#denah';
      var content=document.createElement('div');
      content.className='a4-sl-composition';
      content.innerHTML='<div class="a4-sl-content">'+
        '<div class="a4-sl-eyebrow">'+escH(s.subtitle||'Industry Matching · ASSIE IV 2026')+'</div>'+
        heading+'<p class="a4-sl-p">'+escH(s.desc||'Temukan karya inovasi, bertemu para tenant, dan jelajahi agenda ASSIE IV.')+'</p>'+
        '<div class="a4-hero-actions"><a href="'+escH(link)+'" class="a4-sl-cta">'+escH(s.cta||'Jelajahi Pameran')+uiIcon('arrow')+'</a>'+
        '<a href="#rundown" class="a4-hero-secondary" onclick="a4GoTo(\'rundown\');return false;">Agenda acara <span aria-hidden="true">↗</span></a></div>'+
        '<div class="a4-hero-location">'+uiIcon('pin')+escH(DATA.info.location||'Grand City Atrium, Surabaya')+'</div></div>';
      var overlay=document.createElement('div');overlay.className='a4-sl-overlay';
      div.appendChild(overlay);div.appendChild(content);wrap.appendChild(div);
      var dot=document.createElement('button');
      dot.type='button';dot.className='a4-dot'+(i===0?' on':'');
      dot.textContent=String(i+1).padStart(2,'0');
      dot.setAttribute('aria-label','Sorotan '+(i+1)+': '+(s.title||'ASSIE IV'));
      dot.setAttribute('aria-pressed',i===0?'true':'false');
      dot.onclick=function(){goSlide(i);startSliderTimer();};
      dots.appendChild(dot);
    });
    var hero=document.getElementById('home');
    hero.addEventListener('mouseenter',function(){slHover=true;clearInterval(slTimer);});
    hero.addEventListener('mouseleave',function(){slHover=false;startSliderTimer();});
    hero.addEventListener('focusin',function(){clearInterval(slTimer);});
    hero.addEventListener('focusout',function(){setTimeout(startSliderTimer,0);});
    document.addEventListener('visibilitychange',startSliderTimer);
    updateSlidePause();
    startSliderTimer();
  }
  function goSlide(n){
    var slides=document.querySelectorAll('.a4-sl'),dots=document.querySelectorAll('.a4-dot');
    if(!slides.length) return;
    curSl=(n+slides.length)%slides.length;
    slides.forEach(function(s,i){s.classList.toggle('on',i===curSl);s.setAttribute('aria-hidden',i===curSl?'false':'true');s.inert=i!==curSl;});
    dots.forEach(function(d,i){d.classList.toggle('on',i===curSl);d.setAttribute('aria-pressed',i===curSl?'true':'false');});
  }
  function updateSlidePause(){
    var button=document.getElementById('a4SlidePause');
    if(button){button.innerHTML=uiIcon(slPaused?'play':'pause');button.setAttribute('aria-label',slPaused?'Putar pergantian slide':'Jeda pergantian slide');button.setAttribute('aria-pressed',slPaused?'true':'false');}
  }
  window.a4SlMove=function(dir){goSlide(curSl+dir);startSliderTimer();};
  window.a4ToggleSlides=function(){slPaused=!slPaused;updateSlidePause();startSliderTimer();};
  function startSliderTimer(){
    clearInterval(slTimer);
    var hero=document.getElementById('home');
    if(slPaused||slHover||document.hidden||DATA.slides.length<2||(hero&&hero.contains(document.activeElement))) return;
    slTimer=setInterval(function(){goSlide(curSl+1);},8500);
  }

  /* ══════════════════════════════════════════════════════
     TICKER
     ═══════════════════════════════════════════════════════ */
  function renderTicker(){
    var el=document.getElementById('a4Ticker'); if(!el) return;
    var items=DATA.ticker.concat(DATA.ticker);
    el.innerHTML=items.map(function(t){return '<span class="a4-ticker-item">'+escH(t)+'</span>';}).join('');
  }

  /* ══════════════════════════════════════════════════════
     RUNDOWN
     ═══════════════════════════════════════════════════════ */
  var activeDay=0;
  function renderRundown(){
    var tabs=document.getElementById('a4DayTabs'); if(!tabs) return;
    tabs.innerHTML=DATA.rundown.days.map(function(d,i){
      var label=String(d.label||'Hari '+(i+1));
      var dateParts=label.match(/^([^,]+),\s*(\d{1,2})\s+(.+?)\s+(\d{4})$/);
      var dayText=dateParts?dateParts[1]:label;
      var dateText=dateParts?dateParts[2]+' '+dateParts[3]:'';
      return '<button type="button" class="a4-dt'+(i===activeDay?' on':'')+'" aria-label="'+escH(label)+'" aria-pressed="'+(i===activeDay?'true':'false')+'" onclick="a4SwitchDay('+i+')">'+
        '<span class="a4-dt-order" aria-hidden="true">'+String(i+1).padStart(2,'0')+'</span><span class="a4-dt-copy"><strong>'+escH(dayText)+'</strong>'+(dateText?'<small>'+escH(dateText)+'</small>':'')+'</span></button>';
    }).join('');
    var dayIntro=document.getElementById('a4RundownDayIntro');
    if(dayIntro){
      var selectedDay=DATA.rundown.days[activeDay]||{};
      var dayCount=DATA.rundown.events.filter(function(e){return e.day===activeDay;}).length;
      dayIntro.innerHTML='<span class="a4-rundown-selected-date">'+escH(selectedDay.label||'Jadwal acara')+'</span><span class="a4-rundown-event-count">'+dayCount+' agenda</span>';
    }
    renderTimeline();
  }
  window.a4SwitchDay=function(i){activeDay=i;renderRundown();};
  var typeMap={keynote:{cls:'a4-eb-keynote',lbl:'Keynote'},panel:{cls:'a4-eb-panel',lbl:'Panel'},workshop:{cls:'a4-eb-workshop',lbl:'Workshop'},break:{cls:'a4-eb-break',lbl:'Break'},networking:{cls:'a4-eb-networking',lbl:'Hiburan'},award:{cls:'a4-eb-award',lbl:'Penutupan'}};
  function renderTimeline(){
    var tl=document.getElementById('a4Timeline'); if(!tl) return;
    var now=new Date(), nowMin=now.getHours()*60+now.getMinutes();
    var evs=DATA.rundown.events.filter(function(e){return e.day===activeDay;});
    var monthIndex={januari:0,februari:1,maret:2,april:3,mei:4,juni:5,juli:6,agustus:7,september:8,oktober:9,november:10,desember:11,jan:0,feb:1,mar:2,apr:3,jun:5,jul:6,agu:7,sep:8,okt:9,nov:10,des:11};
    var selectedLabel=(DATA.rundown.days[activeDay]||{}).label||'';
    var dateMatch=selectedLabel.match(/(\d{1,2})\s+([a-z]+)\s+(\d{4})/i);
    var dateIsToday=false;
    if(dateMatch&&Object.prototype.hasOwnProperty.call(monthIndex,dateMatch[2].toLowerCase())){
      dateIsToday=now.getFullYear()===parseInt(dateMatch[3],10)&&now.getMonth()===monthIndex[dateMatch[2].toLowerCase()]&&now.getDate()===parseInt(dateMatch[1],10);
    }
    tl.innerHTML=evs.map(function(e){
      var tm=typeMap[e.type]||typeMap.break;
      function toMinutes(value){var parts=String(value||'0').split(/[.:]/);return parseInt(parts[0],10)*60+parseInt(parts[1]||0,10);}
      var isnow=dateIsToday&&nowMin>=toMinutes(e.time)&&nowMin<toMinutes(e.end||'23.59');
      return '<article class="a4-tli'+(isnow?' now':'')+'">'+
        '<div class="a4-tl-time"><span>'+escH(e.time)+'</span>'+(e.end?'<span class="a4-tl-time-separator">—</span><span>'+escH(e.end)+'</span>':'')+'</div>'+
        '<div class="a4-tl-content"><div class="a4-tl-main"><span class="a4-tl-category">'+escH(tm.lbl)+(isnow?' · Sedang berlangsung':'')+'</span><h3 class="a4-tl-name">'+escH(e.name)+'</h3></div>'+
        (e.loc&&e.loc!=='—'?'<div class="a4-tl-meta">'+escH(e.loc)+'</div>':'')+'</div></article>';
    }).join('')||'<p class="a4-timeline-empty">Jadwal untuk tanggal ini belum diumumkan.</p>';
  }

  /* ══════════════════════════════════════════════════════
     AREA FILTERS & TENANT GRID
     ═══════════════════════════════════════════════════════ */
  var activeArea='all';
  function renderAreaFilters(){
    var el=document.getElementById('a4AreaFilters'); if(!el) return;
    var areas=[
      {key:'all',lbl:'Semua',cls:'a4-af-all'},
      {key:'A',lbl:'Area A – UNAIR',cls:'a4-af-a'},
      {key:'B',lbl:'Area B – Riset & Unit',cls:'a4-af-b'},
      {key:'C',lbl:'Area C – Sponsor',cls:'a4-af-c'},
      {key:'D',lbl:'Area D – Startup/Mitra',cls:'a4-af-d'},
      {key:'E',lbl:'Area E – Inkubasi',cls:'a4-af-e'},
      {key:'F',lbl:'Area F – Inovasi',cls:'a4-af-f'},
      {key:'G',lbl:'Area G – Kuliner/Bisnis',cls:'a4-af-g'},
      {key:'H',lbl:'Area H – Craft/Fashion',cls:'a4-af-h'}
    ];
    el.innerHTML=areas.map(function(a){return '<button class="a4-af '+a.cls+(activeArea===a.key?' on':'')+'" onclick="a4FilterArea(\''+a.key+'\')">'+a.lbl+'</button>';}).join('');
  }
  window.a4FilterArea=function(area){activeArea=area;tenantListExpanded=false;renderAreaFilters();renderTenants();};

  var tenantAreaColors={A:'#3888ff',B:'#11bf8c',C:'#f7bf3b',D:'#a878ff',E:'#23c1e6',F:'#f47962',G:'#9fc943',H:'#ec6cb5'};
  var tenantListExpanded=false;
  function tenantIconSvg(t){
    var details=((t.cat||'')+' '+(t.name||'')).toLowerCase(),paths;
    if(/bank|perbankan|keuangan/.test(details)) paths='<path d="M3 9h18L12 4 3 9Zm2 2v7m4-7v7m6-7v7m4-7v7M3 20h18"/>';
    else if(/riset|lab|stem cell|bionas|science/.test(details)) paths='<path d="M9 3h6m-5 0v6l-5 9a2 2 0 0 0 2 3h10a2 2 0 0 0 2-3l-5-9V3m-6 11h8"/>';
    else if(/kuliner|cookie|kopi|minuman|beras|food/.test(details)) paths='<path d="M5 8h14l-1 12H6L5 8Zm3 0V5a4 4 0 0 1 8 0v3m-9 4h10m-5-9v2"/>';
    else if(/kesehatan|kedokteran|medis|health|penyakit/.test(details)) paths='<path d="M12 3v18M3 12h18"/><circle cx="12" cy="12" r="9"/>';
    else if(/fashion|batik|craft|kerajinan|quilter|tanaman/.test(details)) paths='<path d="M7 4c2 0 3 2 5 2s3-2 5-2m-10 0 10 16M17 4 7 20m-4-8h18"/>';
    else if(/energi|ev\/|teknologi|telkom|transportasi|kai|produksi|industri/.test(details)) paths='<path d="M13 2 5 13h6l-1 9 9-12h-6l1-8Z"/>';
    else if(/pendidikan|universitas|unair|fakultas|press|bahasa/.test(details)) paths='<path d="M3 9 12 4l9 5M5 10v9m4-9v9m6-9v9m4-9v9M3 20h18"/>';
    else if(/musik|band/.test(details)) paths='<path d="M9 18V5l12-2v13M9 10l12-2"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/>';
    else if(/properti/.test(details)) paths='<path d="m3 11 9-8 9 8v9H3v-9Zm6 9v-6h6v6m-9-9h.01M18 11h.01"/>';
    else paths='<path d="m12 3 2.4 5.2 5.6.7-4.1 3.8 1.1 5.5-5-2.8-5 2.8 1.1-5.5L4 8.9l5.6-.7L12 3Z"/>';
    return '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">'+paths+'</svg>';
  }
  function renderTenants(){
    var grid=document.getElementById('a4TenantGrid'); if(!grid) return;
    var list=DATA.tenants.filter(function(t){
      var matchesArea=activeArea==='all'||t.area===activeArea;
      var matchesSearch=!tenantSearch||[t.name,t.id,t.cat,(t.tags||[]).join(' ')].join(' ').toLowerCase().indexOf(tenantSearch)>=0;
      return matchesArea&&matchesSearch;
    });
    var visibleLimit=window.innerWidth<=560?6:9;
    var visibleList=tenantListExpanded?list:list.slice(0,visibleLimit);
    var count=document.getElementById('a4TenantCount');
    if(count) count.textContent=visibleList.length+' dari '+list.length+' tenant ditampilkan';
    grid.innerHTML=visibleList.map(function(t){
      var areaColor=tenantAreaColors[t.area]||'#d4a843';
      return '<button type="button" class="a4-tc" style="--a4-area-color:'+areaColor+'" data-tenant-id="'+escH(t.id)+'" aria-label="Lihat detail '+escH(t.name)+'">'+
        '<span class="a4-tc-mark'+(t.logo?'':' is-fallback')+'">'+(t.logo?'<img src="'+escH(t.logo)+'" alt="Logo '+escH(t.name)+'" loading="lazy" onerror="this.parentNode.classList.add(&quot;is-fallback&quot;)">':'')+'<span class="a4-tc-fallback" aria-hidden="true">'+tenantIconSvg(t)+'</span></span>'+
        '<span class="a4-tc-copy"><span class="a4-tc-overline"><span class="a4-tc-area-dot a4-tc-area-'+escH(t.area)+'"></span>AREA '+escH(t.area)+(t.booth_no ? ' <span class="a4-tc-sep">/</span> BOOTH '+escH(t.booth_no)+' ('+escH(t.code||t.id.toUpperCase())+')' : ' <span class="a4-tc-sep">/</span> BOOTH '+escH(String(t.id).toUpperCase()))+'</span>'+
        '<span class="a4-tc-name">'+escH(t.name)+'</span>'+
        (t.instansi && t.instansi !== t.name ? '<span class="a4-tc-instansi">'+escH(t.instansi.length > 55 ? t.instansi.slice(0, 52) + '...' : t.instansi)+'</span>' : '')+
        '<span class="a4-tc-cat">'+escH(t.cat||'Peserta pameran')+'</span>'+
        '</span><span class="a4-tc-arrow" aria-hidden="true">&#8599;</span></button>';
    }).join('')||'<p class="a4-tenant-empty">'+(DATA.tenants.length?'Tidak ada tenant yang cocok. Coba area atau kata kunci lain.':'Daftar tenant belum tersedia.')+'</p>';
    var more=document.getElementById('a4TenantMore');
    if(more){more.hidden=list.length<=visibleLimit;more.textContent=tenantListExpanded?'Tampilkan lebih sedikit':'Lihat semua '+list.length+' tenant';more.setAttribute('aria-expanded',tenantListExpanded?'true':'false');}
    if(!grid._a4TenantEvents){
      grid._a4TenantEvents=true;
      grid.addEventListener('click',function(e){var item=e.target.closest('.a4-tc[data-tenant-id]');if(item) window.a4OpenModal(item.getAttribute('data-tenant-id'));});
    }
    var stEl=document.getElementById('a4stTenant'),stEl2=document.getElementById('a4stTotal');
    if(stEl) stEl.textContent=DATA.tenants.length;
    if(stEl2) stEl2.textContent=Object.keys(boothNumToCode).length;
  }
  var tenantSearch='';
  window.a4SearchTenants=function(value){tenantSearch=String(value||'').trim().toLowerCase();tenantListExpanded=false;renderTenants();};
  window.a4ToggleTenants=function(){tenantListExpanded=!tenantListExpanded;renderTenants();};
  window.a4ShowAllTenants=function(){tenantListExpanded=true;renderTenants();var section=document.getElementById('tenant-directory');if(section)section.scrollIntoView({behavior:'smooth',block:'start'});};

  /* ══════════════════════════════════════════════════════
     DENAH SVG — area-grouped, sinkron dari tenant DB + PASINBIS
     ═══════════════════════════════════════════════════════ */
  var areaClr={
    A:{fill:'#1e3a6e',stroke:'#3b82f6',label:'Area A — UNAIR'},
    B:{fill:'#14532d',stroke:'#22c55e',label:'Area B — Mitra'},
    C:{fill:'#78350f',stroke:'#f59e0b',label:'Area C — Eksternal'},
    D:{fill:'#4c1d95',stroke:'#a855f7',label:'Area D — Startup'},
    E:{fill:'#0c4a6e',stroke:'#06b6d4',label:'Area E — Institusi'},
  };
  var denahActiveArea='all';

  function renderDenahFilters(){
    var el=document.getElementById('a4DenahFilters'); if(!el) return;
    var areas=[{key:'all',lbl:'Semua Area',clr:'#d4a843'}];
    Object.keys(areaClr).forEach(function(k){areas.push({key:k,lbl:areaClr[k].label,clr:areaClr[k].stroke});});
    el.innerHTML=areas.map(function(a){
      var on=denahActiveArea===a.key;
      return '<button class="a4-df-btn'+(on?' on':'')+'" style="'+(on?'background:'+a.clr+'22;border-color:'+a.clr+';color:'+a.clr:'')+'" onclick="a4SetDenahArea(\''+a.key+'\')">'+escH(a.lbl)+'</button>';
    }).join('');
  }
  window.a4SetDenahArea=function(area){denahActiveArea=area;renderDenahFilters();renderMap();};

  function renderMapLegend(){
    var el=document.getElementById('a4MapLegend'); if(!el) return;
    el.innerHTML=Object.keys(areaClr).map(function(k){
      var c=areaClr[k];
      return '<span class="a4-ml"><span class="a4-ml-box" style="background:'+c.fill+';border:1px solid '+c.stroke+'"></span>'+escH(c.label)+'</span>';
    }).join('');
  }

  function renderMap(){
    var svg=document.getElementById('a4FloorMap'); if(!svg) return;
    var cfg         = window.ASSIE4_CFG||{};
    var pb          = cfg.pasinbis||{};
    // Nama dan sub-label PASINBIS dari admin — SINKRON otomatis
    var pasinbisNama= pb.nama||'PASINBIS UNAIR';
    var pasinbisDesk= pb.desk||'pasinbis.unair.ac.id';
    var pasinbisUrl = pb.url ||'https://pasinbis.unair.ac.id';

    // Kelompokkan tenant per area
    var tenants=DATA.tenants||[];
    var byArea={A:[],B:[],C:[],D:[],E:[]};
    tenants.forEach(function(t){
      if(byArea[t.area]!==undefined&&(denahActiveArea==='all'||t.area===denahActiveArea)) byArea[t.area].push(t);
    });

    var BW=58,BH=42,GAP=6,PAD=14;
    var AREA_ORDER=['A','B','C','D','E'];
    var areaLayouts={};
    var totalH=PAD;
    AREA_ORDER.forEach(function(area){
      var booths=byArea[area];
      if(!booths.length){areaLayouts[area]={y:totalH,rows:0,h:0};return;}
      var cols=Math.min(booths.length,Math.floor((940-PAD*2)/(BW+GAP)));
      cols=Math.max(cols,1);
      var rows=Math.ceil(booths.length/cols);
      var h=20+rows*(BH+GAP)+PAD;
      areaLayouts[area]={y:totalH,rows:rows,cols:cols,h:h};
      totalH+=h+8;
    });
    // Stage + PASINBIS row
    var stageY=totalH+8;
    totalH=stageY+60+PAD;

    var VW=960;
    svg.setAttribute('viewBox','0 0 '+VW+' '+totalH);
    svg.setAttribute('width','100%');
    svg.setAttribute('height',totalH);
    svg.style.minHeight = totalH + 'px';
    var html='<rect width="'+VW+'" height="'+totalH+'" fill="#060b18"/>';

    AREA_ORDER.forEach(function(area){
      var info=areaLayouts[area];
      if(!info||!info.rows) return;
      var c=areaClr[area],booths=byArea[area],y0=info.y,cols=info.cols;
      html+='<rect x="'+PAD+'" y="'+y0+'" width="'+(VW-PAD*2)+'" height="'+info.h+'" fill="'+c.fill+'18" stroke="'+c.stroke+'44" stroke-width="1" rx="8"/>';
      html+='<text x="'+(PAD+10)+'" y="'+(y0+15)+'" font-size="10" font-weight="800" font-family="Syne,sans-serif" fill="'+c.stroke+'" opacity=".85">'+escH(areaClr[area].label.toUpperCase())+'</text>';
      booths.forEach(function(t,i){
        var col=i%cols,row=Math.floor(i/cols);
        var bx=PAD+col*(BW+GAP),by=y0+20+row*(BH+GAP);
        var isPasinbis=(t.id==='PASINBIS'||(t.name&&t.name.toLowerCase().indexOf('pasinbis')>=0));
        var clickFn=isPasinbis?'a4BoothClickPasinbis()':'a4OpenModal(\''+escH(t.id)+'\')';
        var fill=isPasinbis?'#1a2a1a':c.fill, sw=isPasinbis?'2':'0.8', sc=isPasinbis?'#d4a843':c.stroke;
        var dataAttr = isPasinbis ? 'data-fn="pasinbis"' : 'data-id="'+escH(t.id)+'"';
        html+='<g class="a4-booth" '+dataAttr+' style="cursor:pointer" onmouseenter="a4ShowTip(event,\''+escH(t.id)+'\')" onmouseleave="a4HideTip()">';
        html+='<rect x="'+bx+'" y="'+by+'" width="'+BW+'" height="'+BH+'" rx="5" fill="'+fill+'" stroke="'+sc+'" stroke-width="'+sw+'" style="transition:all .15s"/>';
        var idLabel=t.id.length>5?t.id.substring(0,5):t.id;
        html+='<text x="'+(bx+BW/2)+'" y="'+(by+BH/2-3)+'" font-size="8" font-weight="700" fill="rgba(255,255,255,.9)" text-anchor="middle" font-family="Syne,sans-serif">'+escH(idLabel)+'</text>';
        var sName=t.name?t.name.split(' ').slice(0,2).join(' '):'';
        if(sName.length>12) sName=sName.substring(0,10)+'…';
        if(sName) html+='<text x="'+(bx+BW/2)+'" y="'+(by+BH/2+8)+'" font-size="5.5" fill="rgba(255,255,255,.65)" text-anchor="middle" font-family="Plus Jakarta Sans,sans-serif">'+escH(sName)+'</text>';
        html+='</g>';
      });
    });

    // STAGE — gunakan data-fn untuk event delegation
    html+='<g class="a4-booth" data-fn="stage" style="cursor:pointer">';
    html+='<rect x="'+PAD+'" y="'+stageY+'" width="240" height="52" rx="8" fill="#3a0808" stroke="#dc2626" stroke-width="2"/>';
    html+='<text x="'+(PAD+120)+'" y="'+(stageY+22)+'" font-size="12" font-weight="800" fill="#fca5a5" text-anchor="middle" font-family="Syne,sans-serif" pointer-events="none"> MAIN STAGE</text>';
    html+='<text x="'+(PAD+120)+'" y="'+(stageY+38)+'" font-size="9" fill="rgba(252,165,165,.7)" text-anchor="middle" font-family="Plus Jakarta Sans,sans-serif" pointer-events="none">Klik untuk lihat jadwal acara</text>';
    html+='</g>';

    // BOOTH PASINBIS — gunakan data-fn untuk event delegation
    var pbX=PAD+260,pbY=stageY;
    var pbLabel=pasinbisNama.length>18?pasinbisNama.substring(0,16)+'…':pasinbisNama;
    var pbSub  =pasinbisDesk.length>30?pasinbisDesk.substring(0,28)+'…':pasinbisDesk;
    html+='<g class="a4-booth" data-fn="pasinbis" style="cursor:pointer">';
    html+='<rect x="'+pbX+'" y="'+pbY+'" width="200" height="52" rx="8" fill="#1a2a1a" stroke="#d4a843" stroke-width="2"/>';
    html+='<text x="'+(pbX+100)+'" y="'+(pbY+21)+'" font-size="11" font-weight="800" fill="#d4a843" text-anchor="middle" font-family="Syne,sans-serif" pointer-events="none"> '+escH(pbLabel)+'</text>';
    html+='<text x="'+(pbX+100)+'" y="'+(pbY+37)+'" font-size="8" fill="rgba(212,168,67,.65)" text-anchor="middle" font-family="Plus Jakarta Sans,sans-serif" pointer-events="none">'+escH(pbSub)+'</text>';
    html+='</g>';

    svg.innerHTML=html;

    // FIX: SVG onclick via innerHTML tidak reliable di semua browser
    // Gunakan event delegation pada wrapper
    var wrap = document.getElementById('a4MapWrap');
    if (wrap && !wrap._a4delegated) {
      wrap._a4delegated = true;
      wrap.addEventListener('click', function(e) {
        var target = e.target;
        // Naik ke parent g element
        while (target && target !== wrap) {
          if (target.classList && target.classList.contains('a4-booth')) {
            var fn = target.getAttribute('data-fn');
            if (fn === 'stage')    { window.a4OpenStage(); break; }
            if (fn === 'pasinbis') { window.a4BoothClickPasinbis(); break; }
            var tid = target.getAttribute('data-id');
            if (tid) { window.a4OpenModal(tid); break; }
          }
          target = target.parentNode;
        }
      });
    }
  }

  /* ── Stage Modal — jadwal acara ── */
  window.a4OpenStage=function(){
    var head=document.getElementById('a4ModalHead'),body=document.getElementById('a4ModalBody');
    if(!head||!body) return;
    head.innerHTML='<button class="a4-m-close" onclick="a4CloseModal()">&#x2715;</button>'+
      '<div class="a4-m-num" style="color:#ef4444">'+uiIcon('mic')+'</div>'+
      '<div class="a4-m-name">Main Stage</div>'+
      '<div class="a4-m-area">Grand City Atrium</div>';
    var now=new Date(),nowMin=now.getHours()*60+now.getMinutes();
    var events=DATA.rundown&&DATA.rundown.events?DATA.rundown.events:[];
    var dayMap={};
    events.forEach(function(e){if(!dayMap[e.day])dayMap[e.day]=[];dayMap[e.day].push(e);});
    var days=DATA.rundown&&DATA.rundown.days?DATA.rundown.days:[];
    var html='<div class="a4-m-section-label">'+uiIcon('calendar')+' Jadwal Acara</div>';
    Object.keys(dayMap).sort().forEach(function(d){
      var dayLbl=(days[d]&&days[d].label)?days[d].label:'Hari '+(parseInt(d)+1);
      html+='<div style="font-size:11px;font-weight:700;color:var(--a4-gold);margin:12px 0 6px;text-transform:uppercase;letter-spacing:1px">'+escH(dayLbl)+'</div>';
      dayMap[d].forEach(function(e){
        var tm=typeMap[e.type]||typeMap.break;
        var eMin=parseInt((e.time||'0').split('.')[0])*60+parseInt((e.time||'0').split('.')[1]||0);
        var endMin=e.end?parseInt(e.end.split('.')[0])*60+parseInt(e.end.split('.')[1]||0):eMin+60;
        var isnow=(nowMin>=eMin&&nowMin<endMin);
        html+='<div class="a4-tl-card'+(isnow?' now':'')+'" style="margin-bottom:8px;padding:10px 14px">';
        html+='<div class="a4-tl-time"><span class="a4-ev-badge '+tm.cls+'">'+tm.lbl+'</span>'+escH(e.time)+(e.end?' – '+escH(e.end):'')+(isnow?' <span style="color:#22c55e;font-weight:700">&#9679; BERLANGSUNG</span>':'')+'</div>';
        html+='<div class="a4-tl-name">'+escH(e.name)+'</div>';
        if(e.loc&&e.loc!=='—') html+='<div class="a4-tl-meta">'+uiIcon('pin')+' '+escH(e.loc)+'</div>';
        html+='</div>';
      });
    });
    body.innerHTML=html;
    var modal=document.getElementById('a4Modal');
    if(modal){modal.classList.add('on');document.body.style.overflow='hidden';}
  };

  /* ── Booth PASINBIS — modal info dari admin (sinkron) ── */
  window.a4BoothClickPasinbis=function(){
    var cfg=window.ASSIE4_CFG||{},pb=cfg.pasinbis||{};
    var url=pb.url||'https://pasinbis.unair.ac.id',nama=pb.nama||'PASINBIS UNAIR',
        desk=pb.desk||'',logo=pb.logo||'',ig=pb.ig||'',web=pb.web||'';
    var head=document.getElementById('a4ModalHead'),body=document.getElementById('a4ModalBody');
    if(!head||!body){window.open(url,'_blank');return;}
    head.innerHTML=
      '<button class="a4-m-close" onclick="a4CloseModal()">&#x2715;</button>'+
      '<div class="a4-m-head-top">'+
        (logo?'<img src="'+escH(logo)+'" class="a4-m-logo-img" alt="'+escH(nama)+'">':'<div class="a4-m-logo-ph">'+uiIcon('building')+'</div>')+
        '<div>'+
          '<div class="a4-m-num" style="color:#d4a843">PASINBIS</div>'+
          '<div class="a4-m-name">'+escH(nama)+'</div>'+
          '<div class="a4-m-area"><span class="a4-m-area-badge" style="background:#d4a84322;color:#d4a843;border:1px solid #d4a84344">Booth Resmi Penyelenggara</span></div>'+
        '</div></div>';
    var igUrl=ig?(ig.indexOf('http')===0?ig:'https://instagram.com/'+ig.replace('@','')):'' ;
    var kHtml='';
    if(url||ig||web){
      kHtml='<div class="a4-m-section-label">'+uiIcon('globe')+' Kontak & Media Sosial</div><div class="a4-m-kontak-list">';
      if(url) kHtml+='<div class="a4-m-kr"><span class="a4-m-ki">'+uiIcon('globe')+'</span><span class="a4-m-kl">Website</span><a href="'+escH(url)+'" target="_blank" class="a4-m-kv">'+escH(url.replace(/^https?:\/\//,''))+'</a></div>';
      if(ig)  kHtml+='<div class="a4-m-kr"><span class="a4-m-ki">'+uiIcon('camera')+'</span><span class="a4-m-kl">Instagram</span><a href="'+escH(igUrl)+'" target="_blank" class="a4-m-kv">'+escH(ig)+'</a></div>';
      if(web) kHtml+='<div class="a4-m-kr"><span class="a4-m-ki">'+uiIcon('bag')+'</span><span class="a4-m-kl">TokoUA</span><a href="'+escH(web)+'" target="_blank" class="a4-m-kv">'+escH(web.replace(/^https?:\/\//,''))+'</a></div>';
      kHtml+='</div>';
    }
    body.innerHTML=(desk?'<div class="a4-m-desc">'+escH(desk)+'</div>':'')+kHtml+
      '<hr class="a4-m-divider"><div style="display:flex;gap:10px;flex-wrap:wrap">'+
      '<a href="'+escH(url)+'" target="_blank" class="a4-m-shop">'+uiIcon('globe')+' Buka Website PASINBIS</a>'+
      (web?'<a href="'+escH(web)+'" target="_blank" class="a4-btn-out" style="font-size:13px">'+uiIcon('bag')+' TokoUA</a>':'')+
      '</div>';
    var modal=document.getElementById('a4Modal');
    if(modal){modal.classList.add('on');document.body.style.overflow='hidden';}
  };

  /* ── Zoom / Pan ── */
  var mapScale=1;
  window.a4ZoomMap=function(f){var svg=document.getElementById('a4FloorMap');if(!svg)return;mapScale=Math.min(3,Math.max(0.4,mapScale*f));svg.style.transform='scale('+mapScale+')';svg.style.transformOrigin='top left';};
  window.a4ResetZoom=function(){var svg=document.getElementById('a4FloorMap');if(svg){mapScale=1;svg.style.transform='';svg.style.transformOrigin='';}};

  /* ══════════════════════════════════════════════════════
     DENAH GAMBAR UPLOAD
     ═══════════════════════════════════════════════════════ */
  var lbImages=[],lbIdx=0;
  function renderDenahImgs(){
    var imgs=DATA.denah||[],wrap=document.getElementById('a4DenahImgs'),gal=document.getElementById('a4DenahGallery');
    if(!wrap||!gal) return;
    if(!imgs.length){wrap.style.display='none';return;}
    lbImages=imgs; wrap.style.display='block';
    gal.innerHTML=imgs.map(function(img,i){
      return '<div class="a4-denah-card" onclick="a4OpenLightbox('+i+')">'+
        '<div class="a4-denah-img-wrap"><img src="'+escH(img.url)+'" alt="'+escH(img.caption||('Denah '+(i+1)))+'" loading="lazy">'+
        '<div class="a4-denah-overlay"><span>Perbesar</span></div></div>'+
        (img.caption?'<div class="a4-denah-caption">'+escH(img.caption)+'</div>':'')+
        '</div>';
    }).join('');
  }
  window.a4OpenLightbox=function(i){
    lbIdx=i;var lb=document.getElementById('a4Lightbox'),img=document.getElementById('a4LbImg'),cap=document.getElementById('a4LbCaption');
    if(!lb||!img) return;
    img.src=lbImages[i].url; cap.textContent=lbImages[i].caption||'';
    document.getElementById('a4LbPrev').style.display=lbImages.length>1?'flex':'none';
    document.getElementById('a4LbNext').style.display=lbImages.length>1?'flex':'none';
    lb.classList.add('on'); document.body.style.overflow='hidden';
  };
  window.a4CloseLightbox=function(){var lb=document.getElementById('a4Lightbox');if(lb)lb.classList.remove('on');document.body.style.overflow='';};
  window.a4LbNav=function(d){lbIdx=(lbIdx+d+lbImages.length)%lbImages.length;window.a4OpenLightbox(lbIdx);};

  /* ══════════════════════════════════════════════════════
     TOOLTIP
     ═══════════════════════════════════════════════════════ */
  var ttEl=document.getElementById('a4Tooltip');
  window.a4ShowTip=function(e,id){
    var t=DATA.tenants.find(function(x){return x.id===id;});
    if(!t||!ttEl) return;
    ttEl.innerHTML='<div class="a4-tt-num">'+escH(t.id)+'</div><div class="a4-tt-name">'+escH(t.name)+'</div><div class="a4-tt-cat">'+escH(t.cat)+'</div>';
    ttEl.style.left=(e.clientX+14)+'px'; ttEl.style.top=(e.clientY-10)+'px'; ttEl.style.opacity='1';
  };
  window.a4HideTip=function(){if(ttEl) ttEl.style.opacity='0';};
  window.a4MapTip=function(e,no){
    if(!ttEl) return;
    var code=boothNumToCode[no]||'',tenant=boothTenant(no);
    ttEl.innerHTML='<div class="a4-tt-code">Area '+escH(code.charAt(0))+' / '+escH(code)+'</div>'+
      '<div class="a4-tt-name">'+escH(tenant&&tenant.name?tenant.name:'Tenant belum diumumkan')+'</div>'+
      '<div class="a4-tt-cat">Booth '+escH(no)+'</div>';
    ttEl.style.left=Math.max(12,Math.min(e.clientX+16,window.innerWidth-ttEl.offsetWidth-12))+'px';
    ttEl.style.top=Math.max(12,Math.min(e.clientY+16,window.innerHeight-ttEl.offsetHeight-12))+'px';
    ttEl.style.opacity='1';
  };

  /* ══════════════════════════════════════════════════════
     MODAL DETAIL BOOTH
     ═══════════════════════════════════════════════════════ */
  var areaClrFull=tenantAreaColors;
  var presUrl=(window.ASSIE4_CFG&&ASSIE4_CFG.presensiUrl)||'/presensi-booth-assie4/';

  var boothNumToCode = {
    1:'A1', 2:'A2', 3:'A3', 4:'A4', 5:'A5', 6:'A6', 7:'A7', 8:'A8', 9:'A9', 10:'A10',
    11:'A11', 12:'A12', 13:'A13', 14:'A14', 15:'A15', 16:'A16', 17:'A17', 18:'A18', 19:'A19', 20:'A20', 21:'A21',
    22:'D1', 23:'D2', 24:'D3', 25:'D4', 26:'D5', 27:'D6', 28:'D7', 29:'D8', 30:'D9', 31:'D10',
    32:'D11', 33:'D12', 34:'D13', 35:'D14', 36:'D15', 37:'D16',
    38:'C1', 39:'C2', 40:'C3', 41:'C4', 42:'C5', 43:'C6', 44:'C7',
    45:'E1', 46:'E2', 47:'E3', 48:'E4', 49:'E5', 50:'E6',
    51:'F1', 52:'F2', 53:'F3', 54:'F4', 55:'F5', 56:'F6', 57:'F7', 58:'F8', 59:'F9', 60:'F10',
    61:'F11', 62:'F12', 63:'F13', 64:'F14', 65:'F15', 66:'F16', 67:'F17', 68:'F18', 69:'F19', 70:'F20', 71:'F21', 72:'F22',
    73:'G1', 74:'G2', 75:'G3', 76:'G4', 77:'G5', 78:'G6', 79:'G7', 80:'G8',
    81:'H1', 82:'H2', 83:'H3', 84:'H4', 85:'H5', 86:'H6', 87:'H7', 88:'H8', 89:'H9', 90:'H10',
    91:'H11', 92:'H12', 93:'H13', 94:'H14', 95:'H15', 96:'H16',
    97:'B1', 98:'B2', 99:'B3', 100:'B4', 101:'B5', 102:'B6', 103:'B7', 104:'B8', 105:'B9', 106:'B10'
  };

  function boothTenant(no){
    if(no==null) return null;
    var n = parseInt(no, 10);
    var sNo = String(no).trim();
    var mappedCode = (boothNumToCode[n] || boothNumToCode[sNo] || '').toUpperCase();
    var sLowerCode = mappedCode.toLowerCase();
    var sLower = sNo.toLowerCase();

    return (DATA.tenants||[]).find(function(t){
      if(!t) return false;
      var tBooth = (t.booth_no !== undefined && t.booth_no !== null && t.booth_no !== '') ? parseInt(t.booth_no, 10) : null;
      var tCode = String(t.code || '').trim().toLowerCase();
      var tId = String(t.id || '').trim().toLowerCase();

      return (tBooth !== null && !isNaN(tBooth) && tBooth === n) ||
             (tBooth !== null && String(tBooth) === sNo) ||
             (mappedCode && (tCode === sLowerCode || tId === sLowerCode)) ||
             (tCode && tCode === sLower) ||
             (tId && tId === sLower);
    });
  }

  function boothStatus(no){
    var tenant=boothTenant(no);
    if(tenant && tenant.name){
      return tenant.name + (tenant.instansi && tenant.instansi !== tenant.name ? ' ('+tenant.instansi+')' : '');
    }
    return 'Booth belum terisi';
  }

  window.a4OpenModal=function(id){
    var s=String(id).trim().toLowerCase();
    var n=parseInt(id, 10);
    var mappedCode=(boothNumToCode[n]||boothNumToCode[s]||'').toLowerCase();

    var t=(DATA.tenants||[]).find(function(x){
      if(!x) return false;
      var xId=String(x.id||'').trim().toLowerCase();
      var xCode=String(x.code||'').trim().toLowerCase();
      var xBooth=(x.booth_no!==undefined&&x.booth_no!==null&&x.booth_no!=='')?parseInt(x.booth_no,10):null;

      return xId===s ||
             xCode===s ||
             (xBooth!==null&&!isNaN(xBooth)&&xBooth===n) ||
             String(xBooth)===s ||
             (mappedCode && (xId===mappedCode || xCode===mappedCode));
    });
    if(!t) return;

    t={
      id:t.id||'',
      booth_no:t.booth_no||'',
      code:t.code||(t.id?t.id.toUpperCase():''),
      cluster:t.cluster||'',
      area:t.area||'A',
      name:t.name||'',
      instansi:t.instansi||'',
      pic:t.pic||'',
      cat:t.cat||'',
      desc:t.desc||'',
      tags:Array.isArray(t.tags)?t.tags:[],
      logo:t.logo||'',
      contact:t.contact||'',
      whatsapp:t.whatsapp||'',
      web:t.web||'',
      instagram:t.instagram||'',
      facebook:t.facebook||'',
      twitter:t.twitter||'',
      transaksi:t.transaksi||''
    };

    var c=areaClrFull[t.area]||'#d4a843';
    var head=document.getElementById('a4ModalHead'),body=document.getElementById('a4ModalBody');
    if(!head||!body) return;

    var shortName=t.name.length>72&&t.name.indexOf(' (')>0?t.name.split(' (')[0]:t.name;
    head.innerHTML='<button type="button" class="a4-m-close" aria-label="Tutup detail booth" onclick="a4CloseModal()">&#x2715;</button>'+
      '<div class="a4-m-head-top" style="--a4-area-color:'+c+'">'+
        '<div class="a4-m-logo-well">'+
          (t.logo?'<img src="'+escH(t.logo)+'" class="a4-m-logo-img" alt="Logo '+escH(t.name)+'" onerror="this.style.display=\'none\';this.nextElementSibling.style.display=\'grid\';"><span class="a4-m-logo-ph" style="display:none">'+tenantIconSvg(t)+'</span>':'<span class="a4-m-logo-ph">'+tenantIconSvg(t)+'</span>')+
        '</div><div class="a4-m-head-copy">'+
          '<div class="a4-m-kicker">Area '+escH(t.area)+' <span>/</span> Booth '+escH(t.booth_no||t.code)+' <span>·</span> '+escH(t.code)+'</div>'+
          '<h2 class="a4-m-name" id="a4ModalTitle">'+escH(shortName)+'</h2>'+
          (shortName!==t.name?'<p class="a4-m-official">'+escH(t.name)+'</p>':'')+
          (t.instansi && t.instansi !== t.name ? '<p class="a4-m-instansi">'+escH(t.instansi)+'</p>' : '')+
        '</div></div>';

    var details=(t.cat||t.pic||String(t.transaksi).toLowerCase()==='ya')?
      '<dl class="a4-m-facts">'+
        (t.cat?'<div><dt>Kategori</dt><dd>'+escH(t.cat)+'</dd></div>':'')+
        (t.pic?'<div><dt>PIC booth</dt><dd>'+escH(t.pic)+'</dd></div>':'')+
        (String(t.transaksi).toLowerCase()==='ya'?'<div><dt>Transaksi</dt><dd>Tersedia di booth</dd></div>':'')+
      '</dl>':'';

    var formattedDesc = (t.desc || '').replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>').replace(/\*(.*?)\*/g, '<em>$1</em>');
    var descBlock=t.desc?'<section class="a4-m-profile"><h3 class="a4-m-section-label">Tentang tenant</h3><div class="a4-m-desc">'+formattedDesc+'</div></section>':'';

    var igUrl='',twUrl='',waUrl='';
    if(t.instagram){
      var ig=String(t.instagram).trim();
      if(/^https?:\/\//i.test(ig)) igUrl=ig;
      else if(/^(?:www\.)?instagram\.com\//i.test(ig)) igUrl='https://'+ig.replace(/^www\./i,'');
      else if(/^@?[\w.]+$/.test(ig)) igUrl='https://instagram.com/'+ig.replace(/^@/,'');
    }
    if(t.twitter){
      var tw=String(t.twitter).trim();
      if(/^https?:\/\//i.test(tw)) twUrl=tw;
      else if(/^(?:www\.)?(?:x|twitter)\.com\//i.test(tw)) twUrl='https://'+tw.replace(/^www\./i,'');
      else if(/^@?[\w_]+$/.test(tw)) twUrl='https://x.com/'+tw.replace(/^@/,'');
    }
    if(t.whatsapp){
      var rawWa=String(t.whatsapp).trim();
      if(/^\+?\d[\d\s.-]{8,17}$/.test(rawWa)){
        var cleanWa=rawWa.replace(/[^0-9]/g,'');
        if(cleanWa.charAt(0)==='0') cleanWa='62'+cleanWa.substring(1);
        if(cleanWa.length>=10&&cleanWa.length<=15) waUrl='https://wa.me/'+cleanWa;
      }
    }

    function contactLabel(kind,label){
      var paths={
        email:'<rect x="2.5" y="5" width="19" height="14" rx="2"/><path d="m3 6 9 7 9-7"/>',
        whatsapp:'<path d="M20.2 11.7a8.2 8.2 0 0 1-11.8 7.4L4 20l1.1-4.1a8.2 8.2 0 1 1 15.1-4.2Z"/><path d="M9.2 8.8c.3-.3.6-.3.8.1l.9 1.4c.2.3.1.5-.2.8l-.5.5a7.4 7.4 0 0 0 2.4 2.4l.5-.5c.2-.3.5-.4.8-.2l1.4.9c.4.2.4.5.1.8-.4.5-1 1-1.7.9a8.4 8.4 0 0 1-5.5-5.5c-.1-.7.4-1.3 1-1.6Z"/>',
        website:'<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c2.5 2.6 3.8 5.6 3.8 9s-1.3 6.4-3.8 9c-2.5-2.6-3.8-5.6-3.8-9S9.5 5.6 12 3Z"/>',
        instagram:'<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.7" r=".8" fill="currentColor" stroke="none"/>',
        facebook:'<path d="M14.3 21v-8h2.6l.4-3.1h-3V7.8c0-.9.3-1.4 1.5-1.4h1.6V3.6a20 20 0 0 0-2.4-.1c-2.4 0-4 1.5-4 4.2v2.2H8.5V13H11v8"/>',
        twitter:'<path d="M4 3h3.5L20 21h-3.5L4 3ZM20 3 4 21"/>'
      };
      return '<span class="a4-m-kl a4-m-kl-'+kind+'"><svg class="a4-m-app-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">'+paths[kind]+'</svg><span>'+label+'</span></span>';
    }
    var hasKontak=t.contact||t.whatsapp||t.web||t.instagram||t.facebook||t.twitter;
    var kHtml='';
    if(hasKontak){
      kHtml='<section class="a4-m-contact"><h3 class="a4-m-section-label">Kontak &amp; kanal</h3><div class="a4-m-kontak-list">';
      if(t.contact) kHtml+='<div class="a4-m-kr">'+contactLabel('email','Email')+(/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(t.contact)?'<a href="mailto:'+escH(t.contact)+'" class="a4-m-kv">'+escH(t.contact)+'</a>':'<span class="a4-m-kv">'+escH(t.contact)+'</span>')+'</div>';
      if(t.whatsapp) kHtml+='<div class="a4-m-kr">'+contactLabel('whatsapp','WhatsApp')+(waUrl?'<a href="'+escH(waUrl)+'" target="_blank" rel="noopener noreferrer" class="a4-m-kv">'+escH(t.whatsapp)+' ↗</a>':'<span class="a4-m-kv">'+escH(t.whatsapp)+'</span>')+'</div>';
      if(t.web) kHtml+='<div class="a4-m-kr">'+contactLabel('website','Website')+'<a href="'+escH(t.web)+'" target="_blank" rel="noopener noreferrer" class="a4-m-kv">'+escH(t.web.replace(/^https?:\/\//,''))+' ↗</a></div>';
      if(t.instagram) kHtml+='<div class="a4-m-kr">'+contactLabel('instagram','Instagram')+(igUrl?'<a href="'+escH(igUrl)+'" target="_blank" rel="noopener noreferrer" class="a4-m-kv">'+escH(t.instagram)+' ↗</a>':'<span class="a4-m-kv">'+escH(t.instagram)+'</span>')+'</div>';
      if(t.facebook) kHtml+='<div class="a4-m-kr">'+contactLabel('facebook','Facebook')+'<a href="'+escH(t.facebook)+'" target="_blank" rel="noopener noreferrer" class="a4-m-kv">'+escH(t.facebook.replace(/^https?:\/\//,''))+' ↗</a></div>';
      if(t.twitter) kHtml+='<div class="a4-m-kr">'+contactLabel('twitter','X / Twitter')+(twUrl?'<a href="'+escH(twUrl)+'" target="_blank" rel="noopener noreferrer" class="a4-m-kv">'+escH(t.twitter)+' ↗</a>':'<span class="a4-m-kv">'+escH(t.twitter)+'</span>')+'</div>';
      kHtml+='</div></section>';
    }

    body.innerHTML=descBlock+details+kHtml+
      '<div class="a4-m-actions">'+
      (String(t.transaksi).toLowerCase()==='ya'?'<a href="https://tokoua.unair.ac.id/" target="_blank" rel="noopener noreferrer" class="a4-m-shop">Belanja di TokoUA ↗</a>':'')+
      '<a href="'+escH(presUrl)+'" class="a4-btn-out">Presensi booth ↗</a>'+
      '</div>';

    var modal=document.getElementById('a4Modal');
    if(modal){modal.querySelector('.a4-mbox').classList.add('a4-modal-tenant');modal.classList.add('on');document.body.style.overflow='hidden';modal.querySelector('.a4-m-close').focus();}
  };

  window.a4OpenBooth=function(no){
    var tenant=boothTenant(no);
    if(tenant && tenant.name){
      window.a4OpenModal(String(tenant.id));
      return;
    }
    var head=document.getElementById('a4ModalHead'),body=document.getElementById('a4ModalBody');
    if(!head||!body) return;
    var code=boothNumToCode[no]||'',area=code.charAt(0),color=tenantAreaColors[area]||'#d4a843';
    head.innerHTML='<button type="button" class="a4-m-close" aria-label="Tutup detail booth" onclick="a4CloseModal()">&#x2715;</button>'+
      '<div class="a4-m-empty-head" style="--a4-area-color:'+color+'"><span class="a4-m-kicker">Area '+escH(area)+' <span>/</span> Booth '+escH(no)+' <span>·</span> '+escH(code)+'</span>'+
      '<h2 class="a4-m-name" id="a4ModalTitle">Tenant belum diumumkan</h2></div>';
    body.innerHTML='<p class="a4-m-desc">Informasi peserta untuk booth ini belum tersedia. Silakan lihat daftar tenant yang sudah diumumkan.</p>'+
      '<div class="a4-m-actions"><button type="button" class="a4-btn-out" onclick="a4CloseModal();a4ShowAllTenants()">Lihat daftar tenant</button></div>';
    var modal=document.getElementById('a4Modal');if(modal){modal.querySelector('.a4-mbox').classList.add('a4-modal-tenant');modal.classList.add('on');document.body.style.overflow='hidden';modal.querySelector('.a4-m-close').focus();}
  };

  window.a4CloseModal=function(){var m=document.getElementById('a4Modal');if(m){m.classList.remove('on');m.querySelector('.a4-mbox').classList.remove('a4-modal-tenant');document.body.style.overflow='';}};
  document.addEventListener('keydown',function(e){if(e.key==='Escape'&&document.getElementById('a4Modal')?.classList.contains('on'))window.a4CloseModal();});

  /* ── DENAH VENUE ASLI + HOTSPOT BOOTH ────────────────────
     Koordinat mengikuti slide 5 (1820 × 1024). Nomor booth sengaja
     mengikuti kode Area A–H pada spreadsheet pembagian booth. */
  var denahActiveArea='all',denahSelectedBooth=null;
  var areaMeta='ABCDEFGH'.split('').map(function(area){
    return {key:area,label:'Area '+area,color:tenantAreaColors[area]};
  });
  var boothShapes=[];
  var boothCodeToNo={};
  Object.keys(boothNumToCode).forEach(function(no){boothCodeToNo[boothNumToCode[no]]=Number(no);});
  /* Gambar berlabel pada sheet Ploting Booth adalah potongan denah yang diperbesar.
     Konversi koordinatnya ke gambar dasar 1820x1024, lalu ikat ke kode booth resmi. */
  function addCodeBooth(code,rx,ry,rw,rh,angle){
    var scale=1.466,cx=210+rx/scale,cy=167+ry/scale,w=rw/scale,h=rh/scale;
    boothShapes.push({n:boothCodeToNo[code],area:code.charAt(0),code:code,x:cx-w/2,y:cy-h/2,cx:cx,cy:cy,w:w,h:h,angle:angle||0});
  }
  /* F dan H: dua sisi meja, nomor bawah naik ke kanan; nomor atas turun ke kanan. */
  var fXs=[459,507,555,603,677,726,775,824,894,944,994];
  fXs.forEach(function(x,i){addCodeBooth('F'+(i+1),x,181,39,30);addCodeBooth('F'+(22-i),x,151,39,30);});
  var hXs=[1400,1449,1499,1548,1600,1650,1700,1748];
  hXs.forEach(function(x,i){addCodeBooth('H'+(i+1),x,181,39,30);addCodeBooth('H'+(16-i),x,151,39,30);});
  /* E: enam booth di lengkung kiri. G: delapan di lengkung tengah. */
  [[1,358,357,-43],[2,380,323,-29],[3,396,289,-12],[4,399,255,0],[5,394,220,17],[6,380,185,32]].forEach(function(p){addCodeBooth('E'+p[0],p[1],p[2],31,32,p[3]);});
  [[1,1111,277,-43],[2,1150,287,-28],[3,1187,291,-10],[4,1224,285,10],[5,1260,268,28],[6,1290,234,43],[7,1305,196,65],[8,1307,155,0]].forEach(function(p){addCodeBooth('G'+p[0],p[1],p[2],31,31,p[3]);});
  /* D: dua kelompok meja diagonal. C: tujuh booth di kiri panggung. */
  [[9,355,444],[8,385,432],[10,382,475],[7,415,465],[11,414,512],[6,445,498],[12,447,548],[5,477,533],
   [13,509,605],[4,530,597],[14,542,637],[3,563,627],[15,574,670],[2,595,657],[16,606,707],[1,627,689]].forEach(function(p){addCodeBooth('D'+p[0],p[1],p[2],32,34,-40);});
  [[7,696,696],[1,725,696],[6,696,741],[2,725,741],[5,696,785],[3,725,785],[4,711,825]].forEach(function(p){addCodeBooth('C'+p[0],p[1],p[2],30,36);});
  /* B: lima pasang booth vertikal di tengah kanan. */
  [[10,1097,388],[9,1127,388],[7,1097,462],[8,1127,462],[6,1097,511],[5,1127,511],
   [3,1097,584],[4,1127,584],[2,1097,625],[1,1127,625]].forEach(function(p){addCodeBooth('B'+p[0],p[1],p[2],29,35);});
  /* A: tiga blok, masing-masing tujuh booth (enam sisi + satu ujung). */
  [[1197,1227],[1297,1327],[1399,1429]].forEach(function(xs,block){
    var start=block*7+1;
    [[0,748],[1,789],[2,832]].forEach(function(row){
      addCodeBooth('A'+(start+row[0]),xs[0],row[1],31,35);
      addCodeBooth('A'+(start+6-row[0]),xs[1],row[1],31,35);
    });
    addCodeBooth('A'+(start+3),(xs[0]+xs[1])/2,871,32,35);
  });

  
  function renderDenahFilters(){
    var el=document.getElementById('a4DenahFilters');if(!el) return;
    var filters=[{key:'all',label:'Semua Area'}].concat(areaMeta);
    el.innerHTML=filters.map(function(filter){var on=denahActiveArea===filter.key;return '<button type="button" class="a4-df-btn'+(on?' on':'')+'" style="--a4-cluster:'+(filter.color||'#d4a843')+'" aria-pressed="'+on+'" onclick="a4SetDenahArea(\''+filter.key+'\')">'+(filter.color?'<span class="a4-cluster-dot" aria-hidden="true"></span>':'')+escH(filter.label)+'</button>';}).join('');
  }
  window.a4SetDenahArea=function(area){
    denahActiveArea=areaMeta.some(function(item){return item.key===area;})?area:'all';
    denahSelectedBooth=null;renderDenahFilters();renderMap();
    if(window.matchMedia('(max-width:768px)').matches){
      window.requestAnimationFrame(function(){
        var wrap=document.getElementById('a4MapWrap');
        if(denahActiveArea==='all'){if(wrap) wrap.scrollTo({left:0,top:0,behavior:'smooth'});return;}
        scrollMapToHotspot(document.querySelector('.a4-map-booth[data-area="'+denahActiveArea+'"]'));
      });
    }
  };
  function renderMapLegend(){
    var el=document.getElementById('a4MapLegend');if(!el) return;
    var selected=areaMeta.find(function(item){return item.key===denahActiveArea;});
    var total=boothShapes.filter(function(booth){return !selected||booth.area===selected.key;}).length;
    var announced=(DATA.tenants||[]).filter(function(tenant){return !selected||tenant.area===selected.key;}).length;
    el.innerHTML='<span class="a4-map-status-dot" style="--a4-cluster:'+(selected?selected.color:'#d4a843')+'"></span>'+
      '<strong>'+(selected?escH(selected.label):'Seluruh denah')+'</strong>'+
      '<span>'+total+' booth · '+announced+' tenant terdaftar</span>';
  }
  function setSelectedBooth(no){
    denahSelectedBooth=String(no);
    document.querySelectorAll('.a4-map-booth[data-booth]').forEach(function(node){node.classList.toggle('is-selected',node.getAttribute('data-booth')===denahSelectedBooth);});
    document.querySelectorAll('.a4-mobile-booth-btn').forEach(function(node){node.classList.toggle('is-selected',node.getAttribute('data-booth')===denahSelectedBooth);});
    if(window.matchMedia('(max-width:768px)').matches) scrollMapToHotspot(document.querySelector('.a4-map-booth[data-booth="'+denahSelectedBooth+'"]'));
  }
  function scrollMapToHotspot(node){
    var wrap=document.getElementById('a4MapWrap');if(!wrap||!node) return;
    var box=node.getBoundingClientRect(),view=wrap.getBoundingClientRect();
    wrap.scrollTo({
      left:wrap.scrollLeft+box.left-view.left+box.width/2-wrap.clientWidth/2,
      top:wrap.scrollTop+box.top-view.top+box.height/2-wrap.clientHeight/2,
      behavior:window.matchMedia('(prefers-reduced-motion: reduce)').matches?'instant':'smooth'
    });
  }
  window.a4MobileBoothClick=function(no){setSelectedBooth(no);window.a4OpenBooth(no);};
  function renderMobileBoothList(){
    var list=document.getElementById('a4MobileBoothList');if(!list) return;
    function buttons(items){
      return '<div class="a4-mobile-booth-grid">'+items.map(function(booth){
        var t=boothTenant(booth.n);
        var color=tenantAreaColors[booth.area];
        var nameSub=t&&t.name?t.name:'Tenant belum diumumkan';
        return '<button type="button" class="a4-mobile-booth-btn'+(String(booth.n)===denahSelectedBooth?' is-selected':'')+'" style="--a4-cluster:'+color+'" data-booth="'+booth.n+'" aria-label="Booth '+escH(booth.code)+', nomor '+booth.n+', '+escH(nameSub)+'" onclick="a4MobileBoothClick('+booth.n+')"><span class="a4-mobile-booth-no">'+escH(booth.code)+'</span><span class="a4-mobile-booth-code">No. '+booth.n+'</span><small>'+escH(nameSub)+'</small></button>';
      }).join('')+'</div>';
    }
    if(denahActiveArea==='all'){
      list.innerHTML='<div class="a4-mobile-booth-label">Pilih booth <span>sesuai area</span></div>'+areaMeta.map(function(meta,i){var items=boothShapes.filter(function(b){return b.area===meta.key;});return '<details class="a4-mobile-cluster"'+(i===0?' open':'')+'><summary style="--a4-cluster:'+meta.color+'"><span class="a4-cluster-dot"></span>'+escH(meta.label)+' <small>'+items.length+' booth</small></summary>'+buttons(items)+'</details>';}).join('');
    } else {
      var selected=areaMeta.find(function(meta){return meta.key===denahActiveArea;});
      var items=boothShapes.filter(function(b){return b.area===denahActiveArea;});
      list.innerHTML='<div class="a4-mobile-booth-label">'+escH(selected.label)+' <span>'+items.length+' booth</span></div>'+buttons(items);
    }
  }
  function renderMap(){
    var svg=document.getElementById('a4FloorMap'),image=document.getElementById('a4FloorMapImage');if(!svg||!image) return;
    var src=DATA.denahBaseImage||DATA.denahDefaultImage||'';
    if(image.getAttribute('src')!==src) image.setAttribute('src',src);
    svg.setAttribute('viewBox','0 0 1820 1024');
    var html=boothShapes.map(function(booth){
      var dim=denahActiveArea!=='all'&&booth.area!==denahActiveArea;
      var title='Booth '+booth.code+' (nomor '+booth.n+') — '+boothStatus(booth.n);
      var color=tenantAreaColors[booth.area]||'#d4a843';
      return '<g class="a4-map-booth'+(dim?' is-dim':'')+(String(booth.n)===denahSelectedBooth?' is-selected':'')+'" style="--a4-cluster:'+color+'" data-booth="'+booth.n+'" data-area="'+booth.area+'" data-code="'+booth.code+'" role="button" tabindex="'+(dim?'-1':'0')+'" aria-hidden="'+dim+'" aria-label="'+escH(title)+'" onmouseenter="a4MapTip(event,'+booth.n+')" onmouseleave="a4HideTip()"><title>'+escH(title)+'</title><rect x="'+booth.x+'" y="'+booth.y+'" width="'+booth.w+'" height="'+booth.h+'" rx="2"'+(booth.angle?' transform="rotate('+booth.angle+' '+booth.cx+' '+booth.cy+')"':'')+'></rect><text x="'+booth.cx+'" y="'+(booth.cy+3)+'" text-anchor="middle" pointer-events="none">'+escH(booth.code.substring(1))+'</text></g>';
    }).join('');
    html+='<g class="a4-map-stage-hotspot" data-fn="stage" role="button" tabindex="0" aria-label="Main Stage, buka jadwal acara"><title>Main Stage — buka jadwal acara</title><rect x="1496" y="185" width="95" height="147" rx="32"></rect><text x="1543" y="266" text-anchor="middle" pointer-events="none">MAIN</text><text x="1543" y="281" text-anchor="middle" pointer-events="none">STAGE</text></g>';
    svg.innerHTML=html;renderMobileBoothList();renderMapLegend();
    var wrap=document.getElementById('a4MapWrap');
    if(wrap&&!wrap._a4denahEvents){
      wrap._a4denahEvents=true;
      function activate(target){if(target.getAttribute('data-fn')==='stage'){window.a4OpenStage();return;}var booth=target.getAttribute('data-booth');if(booth){setSelectedBooth(booth);window.a4OpenBooth(booth);}}
      wrap.addEventListener('click',function(e){var target=e.target.closest?e.target.closest('.a4-map-booth,.a4-map-stage-hotspot'):null;if(target&&wrap.contains(target)) activate(target);});
      wrap.addEventListener('keydown',function(e){if(e.key!=='Enter'&&e.key!==' ') return;var target=e.target.closest?e.target.closest('.a4-map-booth,.a4-map-stage-hotspot'):null;if(target&&wrap.contains(target)){e.preventDefault();activate(target);}});
    }
  }
  var mapScale=1;
  window.a4ZoomMap=function(f){var stage=document.getElementById('a4MapStage');if(!stage)return;mapScale=Math.min(2.5,Math.max(.75,mapScale*f));stage.style.transform='scale('+mapScale+')';};
  window.a4ResetZoom=function(){var stage=document.getElementById('a4MapStage');if(stage){mapScale=1;stage.style.transform='';}};

  /* ══════════════════════════════════════════════════════
     STATS
     ═══════════════════════════════════════════════════════ */
  function refreshStats(){
    var cfg=window.ASSIE4_CFG||{};
    if(!cfg.ajaxUrl) return;
    var xhr=new XMLHttpRequest();
    xhr.open('GET',cfg.ajaxUrl+'?action=assie4_get_stats&_wpnonce='+(cfg.nonce||''));
    xhr.onload=function(){
      try{
        var d=JSON.parse(xhr.responseText);
        if(d&&d.today!==undefined){
          var sT=document.getElementById('a4stToday'),sA=document.getElementById('a4stAll');
          if(sT) sT.textContent=d.today; if(sA) sA.textContent=d.total;
          renderLeaderboard(d.top||[]);
        }
      }catch(e){}
    };
    xhr.send();
  }
  function renderLeaderboard(top){
    var el=document.getElementById('a4LbGrid'); if(!el) return;
    if(!top.length){el.innerHTML='<p class="a4-muted-note">Belum ada presensi hari ini.</p>';return;}
    el.innerHTML=top.slice(0,3).map(function(item,i){
      return '<div class="a4-lbc"><div class="a4-lb-r">'+String(i+1).padStart(2,'0')+'</div>'+
        '<div class="a4-lb-info"><div class="a4-lb-b">Booth '+escH(item.booth)+' — '+(item.name?escH(item.name):'')+'</div>'+
        '<div class="a4-lb-c">'+item.count+' pengunjung</div></div></div>';
    }).join('');
  }

  /* ══════════════════════════════════════════════════════
     BERITA — RSS pasinbis via AJAX proxy
     ═══════════════════════════════════════════════════════ */
  function loadBerita(){
    var grid=document.getElementById('a4NewsGrid'); if(!grid) return;
    var cfg=window.ASSIE4_CFG||{},ajax=cfg.ajaxUrl||'/wp-admin/admin-ajax.php',nonce=cfg.nonce||'';
    fetch(ajax+'?action=assie4_news&_wpnonce='+nonce)
      .then(function(r){return r.json();})
      .then(function(items){
        if(!items||!items.length){
          grid.innerHTML='<div class="a4-news-empty">'+uiIcon('news')+' Belum ada berita. <a href="https://pasinbis.unair.ac.id/category/assie-4-tahun-2026/" target="_blank" style="color:var(--a4-gold)">Kunjungi pasinbis.unair.ac.id &#8594;</a></div>';
          return;
        }
        grid.innerHTML=items.map(function(item){
          var ds='';
          try{var d=new Date(item.date);ds=d.toLocaleDateString('id-ID',{day:'numeric',month:'long',year:'numeric'});}catch(e){ds=item.date||'';}
          var thumb=item.thumb
            ?'<div class="a4-nc-img"><img src="'+escH(item.thumb)+'" alt="" loading="lazy" referrerpolicy="no-referrer"></div>'
            :'<div class="a4-nc-img a4-nc-img-ph"><span>'+uiIcon('news')+'</span></div>';
          return '<a href="'+escH(item.link)+'" target="_blank" class="a4-news-card" title="Baca selengkapnya">'+thumb+
            '<div class="a4-nc-body"><div class="a4-nc-date">'+escH(ds)+'</div>'+
            '<div class="a4-nc-title">'+escH(item.title)+'</div>'+
            (item.desc?'<div class="a4-nc-desc">'+escH(item.desc)+'</div>':'')+
            '</div></a>';
        }).join('');
      })
      .catch(function(){
        grid.innerHTML='<div class="a4-news-empty">Gagal memuat berita. <a href="https://pasinbis.unair.ac.id/category/assie-4-tahun-2026/" target="_blank" style="color:var(--a4-gold)">Buka langsung &#8594;</a></div>';
      });
  }

  /* ══════════════════════════════════════════════════════
     INIT
     ═══════════════════════════════════════════════════════ */
  function initMotion(){
    var nav=document.getElementById('a4Nav');
    document.addEventListener('keydown',function(event){if(event.key==='Escape'&&nav.classList.contains('is-open')){window.a4ToggleMenu(false);document.querySelector('.a4-menu-toggle').focus();}});
    document.addEventListener('click',function(event){if(!nav.contains(event.target))window.a4ToggleMenu(false);});
    if(!('IntersectionObserver' in window))return;
    var spy=new IntersectionObserver(function(entries){entries.forEach(function(entry){if(entry.isIntersecting){navBtns.forEach(function(button){button.classList.toggle('on',(button.getAttribute('onclick')||'').indexOf("'"+entry.target.id+"'")!==-1);});}});},{rootMargin:'-15% 0px -60% 0px'});
    document.querySelectorAll('#home,#rundown,#denah,#berita,#presensi').forEach(function(el){spy.observe(el);});
    if(reduceMotion.matches)return;
    var reveal=new IntersectionObserver(function(entries){entries.forEach(function(entry){if(entry.isIntersecting){entry.target.classList.add('is-visible');reveal.unobserve(entry.target);}});},{threshold:.08});
    document.querySelectorAll('.a4-sec-h,.a4-sec-sub,.a4-tenant-section-head,.a4-pres-box').forEach(function(el){el.classList.add('a4-reveal');reveal.observe(el);});
  }

  function init(){
    renderInfo();
    renderSlider();
    renderTicker();
    renderRundown();
    renderAreaFilters();
    renderTenants();
    renderDenahFilters();
    renderMapLegend();
    renderMap();
    renderDenahImgs();
    loadBerita();
    refreshStats();
    initMotion();
  }

  if(document.readyState==='loading'){
    document.addEventListener('DOMContentLoaded',init);
  } else {
    init();
  }
  setInterval(refreshStats,60000);
  setInterval(loadBerita, 30*60*1000); // Auto-refresh scrape tiap 30 menit
})();

/* ── TokoUA Modal ─────────────────────────────────────── */
(function(){
  window.a4OpenTokoUA = function(){
    var modal = document.getElementById('a4TokoUAModal');
    if(!modal) return;
    modal.classList.add('open');
    document.body.style.overflow = 'hidden';
  };

  window.a4CloseTokoUA = function(){
    var modal = document.getElementById('a4TokoUAModal');
    if(modal) modal.classList.remove('open');
    document.body.style.overflow = '';
  };

  document.addEventListener('keydown', function(e){
    if(e.key === 'Escape') a4CloseTokoUA();
  });
})();
