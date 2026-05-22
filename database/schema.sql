-- ============================================================
-- ATURATUR - DATABASE SCHEMA LENGKAP
-- Engine: MySQL 8.0+ | Charset: utf8mb4
-- ============================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ------------------------------------------------------------
-- 1. PACKAGES (Paket undangan)
-- ------------------------------------------------------------
CREATE TABLE `packages` (
    `id`            TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`          VARCHAR(50)  NOT NULL COMMENT 'Basic, Premium, dll',
    `slug`          VARCHAR(50)  NOT NULL UNIQUE,
    `max_photos`    TINYINT      NOT NULL DEFAULT 5,
    `max_guests`    SMALLINT     NOT NULL DEFAULT 50  COMMENT '-1 = unlimited',
    `duration_days` SMALLINT     NOT NULL DEFAULT 90  COMMENT '-1 = selamanya',
    `price_display` VARCHAR(20)  NOT NULL DEFAULT 'Rp0',
    `wa_template`   TEXT         NULL     COMMENT 'Template pesan order WA',
    `features`      JSON         NULL     COMMENT 'Fitur tambahan sebagai array string',
    `is_active`     TINYINT(1)   NOT NULL DEFAULT 1,
    `sort_order`    TINYINT      NOT NULL DEFAULT 0,
    `created_at`    TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`    TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Paket layanan undangan';

-- Seed data paket
INSERT INTO `packages` (`name`, `slug`, `max_photos`, `max_guests`, `duration_days`, `price_display`, `features`) VALUES
('Basic',   'basic',   0,  50,  -1, 'Rp75.000',  '["RSVP Online","Ucapan & Doa","Daftar Tamu","Musik Latar","Aktif Selamanya"]'),
('Premium', 'premium', 10, -1,  -1, 'Rp150.000', '["10 Foto Galeri","Tamu Unlimited","RSVP Online","Ucapan & Doa","Link Per Tamu","Musik Latar","Aktif Selamanya"]'),
('Ultimate', 'ultimate', -1, -1, -1, 'Rp250.000', '["Foto Unlimited","Tamu Unlimited","RSVP Online","Ucapan & Doa","Link Per Tamu","Musik Latar","Aktif Selamanya","Semua Tema Premium","Support Prioritas"]');


-- ------------------------------------------------------------
-- 2. THEMES (Tema / template undangan)
-- ------------------------------------------------------------
CREATE TABLE `themes` (
    `id`             SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`           VARCHAR(100) NOT NULL,
    `slug`           VARCHAR(100) NOT NULL UNIQUE COMMENT 'Nama folder blade: resources/views/themes/{slug}',
    `preview_image`  VARCHAR(255) NULL,
    `color_palette`  VARCHAR(100) NULL COMMENT 'Deskripsi warna misal: hijau sage, krem',
    `is_premium`     TINYINT(1)   NOT NULL DEFAULT 0,
    `is_active`      TINYINT(1)   NOT NULL DEFAULT 1,
    `sort_order`     SMALLINT     NOT NULL DEFAULT 0,
    `created_at`     TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`     TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Template / tema undangan';

-- Seed data tema awal
INSERT INTO `themes` (`name`, `slug`, `color_palette`, `is_premium`, `sort_order`) VALUES
('Elegant White',  'elegant-white',  'putih, emas',        0, 1),
('Rustic Garden',  'rustic-garden',  'hijau sage, cokelat', 0, 2),
('Modern Minimalist', 'modern-minimalist', 'hitam, putih', 1, 3);


-- ------------------------------------------------------------
-- 3. USERS (Klien / pemilik undangan)
-- ------------------------------------------------------------
CREATE TABLE `users` (
    `id`                BIGINT UNSIGNED  NOT NULL AUTO_INCREMENT,
    `name`              VARCHAR(100)     NOT NULL,
    `email`             VARCHAR(150)     NOT NULL UNIQUE,
    `password`          VARCHAR(255)     NOT NULL,
    `phone`             VARCHAR(20)      NULL,
    `package_id`        TINYINT UNSIGNED NULL,
    `verification_code` VARCHAR(10)      NULL     COMMENT 'Kode OTP dikirim manual via WA',
    `is_verified`       TINYINT(1)       NOT NULL DEFAULT 0,
    `is_active`         TINYINT(1)       NOT NULL DEFAULT 1,
    `role`              ENUM('admin','client') NOT NULL DEFAULT 'client',
    `expires_at`        TIMESTAMP        NULL     COMMENT 'NULL = selamanya (Premium)',
    `notes`             TEXT             NULL     COMMENT 'Catatan internal admin',
    `remember_token`    VARCHAR(100)     NULL,
    `created_at`        TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`        TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_users_package` (`package_id`),
    CONSTRAINT `fk_users_package` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Akun klien dan admin';


-- ------------------------------------------------------------
-- 4. INVITATIONS (Data undangan milik klien)
-- ------------------------------------------------------------
CREATE TABLE `invitations` (
    `id`              BIGINT UNSIGNED  NOT NULL AUTO_INCREMENT,
    `user_id`         BIGINT UNSIGNED  NOT NULL,
    `theme_id`        SMALLINT UNSIGNED NOT NULL,
    `slug`            VARCHAR(100)     NOT NULL UNIQUE COMMENT 'URL: aturatur.com/{slug}',
    `title`           VARCHAR(150)     NOT NULL COMMENT 'Misal: Pernikahan Figa & Iskhand',

    -- Data mempelai
    `groom_name`      VARCHAR(100)     NULL COMMENT 'Nama lengkap mempelai pria',
    `groom_nickname`  VARCHAR(50)      NULL,
    `groom_father`    VARCHAR(100)     NULL,
    `groom_mother`    VARCHAR(100)     NULL,
    `groom_photo`     VARCHAR(255)     NULL COMMENT 'Path foto mempelai pria',
    `bride_name`      VARCHAR(100)     NULL,
    `bride_nickname`  VARCHAR(50)      NULL,
    `bride_father`    VARCHAR(100)     NULL,
    `bride_mother`    VARCHAR(100)     NULL,
    `bride_photo`     VARCHAR(255)     NULL,

    -- Konten tambahan
    `cover_photo`     VARCHAR(255)     NULL COMMENT 'Foto sampul/hero undangan',
    `love_story`      TEXT             NULL COMMENT 'Kisah cinta / caption singkat',
    `opening_quote`   TEXT             NULL COMMENT 'Ayat / quote pembuka undangan',
    `music_url`       VARCHAR(255)     NULL COMMENT 'URL musik latar (YouTube embed / file)',

    -- Status
    `is_active`       TINYINT(1)       NOT NULL DEFAULT 1,
    `view_count`      INT UNSIGNED     NOT NULL DEFAULT 0,
    `created_at`      TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`      TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),
    KEY `idx_invitations_user`  (`user_id`),
    KEY `idx_invitations_theme` (`theme_id`),
    CONSTRAINT `fk_invitations_user`  FOREIGN KEY (`user_id`)  REFERENCES `users`   (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_invitations_theme` FOREIGN KEY (`theme_id`) REFERENCES `themes`  (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Data undangan pernikahan';


-- ------------------------------------------------------------
-- 5. EVENTS (Jadwal acara dalam undangan)
-- ------------------------------------------------------------
CREATE TABLE `events` (
    `id`            BIGINT UNSIGNED  NOT NULL AUTO_INCREMENT,
    `invitation_id` BIGINT UNSIGNED  NOT NULL,
    `type`          ENUM('akad','resepsi','lainnya') NOT NULL DEFAULT 'resepsi',
    `title`         VARCHAR(100)     NOT NULL COMMENT 'Misal: Akad Nikah, Resepsi',
    `date`          DATE             NOT NULL,
    `time_start`    TIME             NOT NULL,
    `time_end`      TIME             NULL,
    `venue_name`    VARCHAR(150)     NULL COMMENT 'Nama gedung / tempat',
    `address`       TEXT             NULL,
    `maps_url`      VARCHAR(500)     NULL COMMENT 'Google Maps embed / link',
    `maps_embed`    TEXT             NULL COMMENT 'iframe embed code (opsional)',
    `sort_order`    TINYINT          NOT NULL DEFAULT 0,
    `created_at`    TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`    TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_events_invitation` (`invitation_id`),
    CONSTRAINT `fk_events_invitation` FOREIGN KEY (`invitation_id`) REFERENCES `invitations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Jadwal acara pada undangan';


-- ------------------------------------------------------------
-- 6. PHOTOS (Galeri foto undangan)
-- ------------------------------------------------------------
CREATE TABLE `photos` (
    `id`            BIGINT UNSIGNED  NOT NULL AUTO_INCREMENT,
    `invitation_id` BIGINT UNSIGNED  NOT NULL,
    `filename`      VARCHAR(255)     NOT NULL COMMENT 'Nama file tersimpan di storage',
    `original_name` VARCHAR(255)     NULL     COMMENT 'Nama file asli saat upload',
    `size_kb`       SMALLINT UNSIGNED NULL    COMMENT 'Ukuran file dalam KB',
    `type`          ENUM('gallery','couple','cover') NOT NULL DEFAULT 'gallery',
    `sort_order`    TINYINT          NOT NULL DEFAULT 0,
    `created_at`    TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_photos_invitation` (`invitation_id`),
    CONSTRAINT `fk_photos_invitation` FOREIGN KEY (`invitation_id`) REFERENCES `invitations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Galeri foto undangan (max 10, 2MB/foto)';


-- ------------------------------------------------------------
-- 7. GUESTS (Daftar tamu undangan)
-- ------------------------------------------------------------
CREATE TABLE `guests` (
    `id`            BIGINT UNSIGNED  NOT NULL AUTO_INCREMENT,
    `invitation_id` BIGINT UNSIGNED  NOT NULL,
    `name`          VARCHAR(150)     NOT NULL COMMENT 'Nama lengkap tamu',
    `slug`          VARCHAR(200)     NOT NULL COMMENT 'URL-friendly: Budi-Sudarsono',
    `phone`         VARCHAR(20)      NULL     COMMENT 'Untuk kirim link via WA',
    `group_label`   VARCHAR(100)     NULL     COMMENT 'Misal: Keluarga Pria, Rekan Kerja',

    -- RSVP
    `rsvp_status`   ENUM('pending','hadir','tidak_hadir','mungkin') NOT NULL DEFAULT 'pending',
    `rsvp_at`       TIMESTAMP        NULL,
    `guest_count`   TINYINT UNSIGNED NOT NULL DEFAULT 1 COMMENT 'Jumlah orang yang hadir',

    -- Check-in
    `checked_in_at` TIMESTAMP        NULL,

    `created_at`    TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`    TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_guests_invitation_slug` (`invitation_id`, `slug`),
    KEY `idx_guests_invitation` (`invitation_id`),
    CONSTRAINT `fk_guests_invitation` FOREIGN KEY (`invitation_id`) REFERENCES `invitations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Daftar tamu dan status RSVP';


-- ------------------------------------------------------------
-- 8. WISHES (Ucapan dan doa dari tamu)
-- ------------------------------------------------------------
CREATE TABLE `wishes` (
    `id`            BIGINT UNSIGNED  NOT NULL AUTO_INCREMENT,
    `invitation_id` BIGINT UNSIGNED  NOT NULL,
    `guest_id`      BIGINT UNSIGNED  NULL     COMMENT 'NULL = tamu tidak terdaftar (isi manual)',
    `sender_name`   VARCHAR(150)     NOT NULL COMMENT 'Nama pengirim (dari form / nama tamu)',
    `message`       TEXT             NOT NULL,
    `is_approved`   TINYINT(1)       NOT NULL DEFAULT 1 COMMENT '0 = disembunyikan oleh admin/klien',
    `created_at`    TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_wishes_invitation` (`invitation_id`),
    KEY `idx_wishes_guest`      (`guest_id`),
    CONSTRAINT `fk_wishes_invitation` FOREIGN KEY (`invitation_id`) REFERENCES `invitations` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_wishes_guest`      FOREIGN KEY (`guest_id`)      REFERENCES `guests`      (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Ucapan dan doa dari tamu';


-- ------------------------------------------------------------
-- 9. ORDERS (Catatan pesanan manual — WA / Shopee)
-- ------------------------------------------------------------
CREATE TABLE `orders` (
    `id`             BIGINT UNSIGNED  NOT NULL AUTO_INCREMENT,
    `user_id`        BIGINT UNSIGNED  NULL     COMMENT 'NULL jika akun belum dibuat',
    `package_id`     TINYINT UNSIGNED NOT NULL,
    `customer_name`  VARCHAR(100)     NOT NULL,
    `customer_phone` VARCHAR(20)      NOT NULL,
    `customer_email` VARCHAR(150)     NULL,
    `source`         ENUM('wa','shopee','langsung') NOT NULL DEFAULT 'wa',
    `shopee_order_id` VARCHAR(100)    NULL,
    `amount`         INT UNSIGNED     NOT NULL DEFAULT 0 COMMENT 'Nominal dalam rupiah',
    `status`         ENUM('pending','paid','processed','done','cancelled') NOT NULL DEFAULT 'pending',
    `notes`          TEXT             NULL COMMENT 'Catatan dari klien atau admin',
    `paid_at`        TIMESTAMP        NULL,
    `created_at`     TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`     TIMESTAMP        NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_orders_user`    (`user_id`),
    KEY `idx_orders_package` (`package_id`),
    CONSTRAINT `fk_orders_user`    FOREIGN KEY (`user_id`)    REFERENCES `users`    (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_orders_package` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Riwayat pesanan manual (WA/Shopee)';


-- ------------------------------------------------------------
-- 10. PERSONAL ACCESS TOKENS (Laravel Sanctum — opsional API)
-- ------------------------------------------------------------
CREATE TABLE `personal_access_tokens` (
    `id`             BIGINT UNSIGNED  NOT NULL AUTO_INCREMENT,
    `tokenable_type` VARCHAR(255)     NOT NULL,
    `tokenable_id`   BIGINT UNSIGNED  NOT NULL,
    `name`           VARCHAR(255)     NOT NULL,
    `token`          VARCHAR(64)      NOT NULL UNIQUE,
    `abilities`      TEXT             NULL,
    `last_used_at`   TIMESTAMP        NULL,
    `expires_at`     TIMESTAMP        NULL,
    `created_at`     TIMESTAMP        NULL,
    `updated_at`     TIMESTAMP        NULL,
    PRIMARY KEY (`id`),
    KEY `idx_pat_tokenable` (`tokenable_type`, `tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ------------------------------------------------------------
-- 11. SESSIONS (Laravel session DB driver)
-- ------------------------------------------------------------
CREATE TABLE `sessions` (
    `id`            VARCHAR(255)     NOT NULL,
    `user_id`       BIGINT UNSIGNED  NULL,
    `ip_address`    VARCHAR(45)      NULL,
    `user_agent`    TEXT             NULL,
    `payload`       LONGTEXT         NOT NULL,
    `last_activity` INT              NOT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_sessions_user`     (`user_id`),
    KEY `idx_sessions_activity` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ------------------------------------------------------------
-- 12. CACHE (Laravel cache DB driver)
-- ------------------------------------------------------------
CREATE TABLE `cache` (
    `key`        VARCHAR(255) NOT NULL,
    `value`      MEDIUMTEXT   NOT NULL,
    `expiration` INT          NOT NULL,
    PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `cache_locks` (
    `key`        VARCHAR(255) NOT NULL,
    `owner`      VARCHAR(255) NOT NULL,
    `expiration` INT          NOT NULL,
    PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ------------------------------------------------------------
-- 13. JOBS (Laravel queue DB driver — opsional untuk email/notif)
-- ------------------------------------------------------------
CREATE TABLE `jobs` (
    `id`           BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `queue`        VARCHAR(255)    NOT NULL,
    `payload`      LONGTEXT        NOT NULL,
    `attempts`     TINYINT UNSIGNED NOT NULL,
    `reserved_at`  INT UNSIGNED    NULL,
    `available_at` INT UNSIGNED    NOT NULL,
    `created_at`   INT UNSIGNED    NOT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_jobs_queue` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- 14. PACKAGE_THEME (Relasi many-to-many paket & tema)
-- ------------------------------------------------------------
CREATE TABLE `package_theme` (
    `package_id` TINYINT UNSIGNED  NOT NULL,
    `theme_id`   SMALLINT UNSIGNED NOT NULL,
    PRIMARY KEY (`package_id`, `theme_id`),
    CONSTRAINT `fk_pt_package` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_pt_theme`   FOREIGN KEY (`theme_id`)   REFERENCES `themes`   (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Relasi paket dengan tema yang tersedia';

-- Seed data relasi
INSERT INTO `package_theme` (`package_id`, `theme_id`) VALUES
(1, 1), -- Basic -> Elegant White
(2, 2), -- Premium -> Rustic Garden
(2, 3), -- Premium -> Modern Minimalist
(3, 1), -- Ultimate -> Elegant White
(3, 2), -- Ultimate -> Rustic Garden
(3, 3); -- Ultimate -> Modern Minimalist

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================
-- END OF SCHEMA
-- Total tabel: 14
-- packages, themes, users, invitations, events,
-- photos, guests, wishes, orders, package_theme,
-- personal_access_tokens, sessions, cache, jobs
-- ============================================================