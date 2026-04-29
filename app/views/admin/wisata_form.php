<?php
$isEdit     = isset($wisata);
$pageTitle  = $isEdit ? 'Edit Wisata' : 'Tambah Wisata';
$formAction = $isEdit
    ? BASE_URL . '/admin/aksi_edit_wisata.php?id=' . $wisata['id']
    : BASE_URL . '/admin/aksi_tambah_wisata.php';

$fasilitasArr = $isEdit ? json_decode($wisata['fasilitas'] ?? '[]', true) : [];
?>

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="<?= BASE_URL ?>/admin/wisata.php" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h2 class="text-white fw-bold mb-0"><?= $pageTitle ?></h2>
        <p class="text-muted mb-0"><?= $isEdit ? 'Perbarui data wisata' : 'Tambahkan destinasi baru' ?></p>
    </div>
</div>


<div id="wisataFormApp">
<form action="<?= $formAction ?>" method="POST" enctype="multipart/form-data">

    <div class="row g-4">

        <div class="col-lg-8">

            <div class="mk-admin-card mb-4">
                <h5 class="text-warning mb-4"><i class="bi bi-info-circle me-2"></i>Informasi Dasar</h5>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label text-muted small fw-semibold">Nama Wisata *</label>
                        <input type="text" name="nama" class="form-control mk-input" required
                               placeholder="Contoh: Taman Lampion Mahakam"
                               value="<?= e($wisata['nama'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small fw-semibold">Kategori *</label>
                        <select name="kategori" class="form-select mk-input" required>
                            <?php foreach (['alam'=>'Alam','budaya'=>'Budaya','wahana'=>'Wahana','kuliner'=>'Kuliner'] as $val => $label): ?>
                            <option value="<?= $val ?>" <?= ($wisata['kategori'] ?? '') === $val ? 'selected' : '' ?>>
                                <?= $label ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small fw-semibold">Status</label>
                        <select name="status" class="form-select mk-input">
                            <option value="aktif" <?= ($wisata['status'] ?? 'aktif') === 'aktif' ? 'selected' : '' ?>>Aktif</option>
                            <option value="nonaktif" <?= ($wisata['status'] ?? '') === 'nonaktif' ? 'selected' : '' ?>>Non-aktif</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label text-muted small fw-semibold">Deskripsi Singkat *</label>
                        <textarea name="deskripsi_singkat" class="form-control mk-input" rows="2" required
                                  placeholder="Ringkasan singkat yang menarik (maks 200 karakter)"><?= e($wisata['deskripsi_singkat'] ?? '') ?></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label text-muted small fw-semibold">Deskripsi Lengkap</label>
                        <textarea name="deskripsi_lengkap" class="form-control mk-input" rows="6"
                                  placeholder="Jelaskan detail tentang destinasi ini..."><?= e($wisata['deskripsi_lengkap'] ?? '') ?></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label text-muted small fw-semibold">Lokasi / Alamat</label>
                        <input type="text" name="lokasi" class="form-control mk-input"
                               placeholder="Contoh: Jl. Slamet Riyadi, Karang Asam Ilir, Samarinda Ulu"
                               value="<?= e($wisata['lokasi'] ?? '') ?>">
                    </div>
                </div>
            </div>


            <div class="mk-admin-card mb-4">
                <h5 class="text-warning mb-4"><i class="bi bi-check2-circle me-2"></i>Fasilitas</h5>
                <div class="vstack gap-2 mb-3" id="fasilitasList">
                    <template v-for="(item, idx) in fasilitasList" :key="idx">
                        <div class="d-flex gap-2">
                            <input type="text" name="fasilitas[]" v-model="fasilitasList[idx]"
                                   class="form-control mk-input"
                                   :placeholder="'Fasilitas ' + (idx+1)">
                            <button type="button" @click="hapusFasilitas(idx)"
                                    class="btn btn-outline-danger btn-sm flex-shrink-0"
                                    title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </template>
                </div>
                <button type="button" @click="tambahFasilitas"
                        class="btn btn-outline-warning btn-sm">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Fasilitas
                </button>
                <div class="mt-3">
                    <small class="text-muted">Contoh: WiFi Gratis, Area Parkir, Musala, Toilet Bersih</small>
                </div>
            </div>

        </div>


        <div class="col-lg-4">

            <!-- Foto -->
            <div class="mk-admin-card mb-4">
                <h5 class="text-warning mb-4"><i class="bi bi-image me-2"></i>Foto Utama</h5>
                <?php if ($isEdit && !empty($wisata['foto_utama'])): ?>
                <div class="mb-3 text-center">
                    <img src="<?= fotoWisata($wisata['foto_utama']) ?>"
                         alt="Foto saat ini" class="img-fluid rounded-3"
                         style="max-height:180px;object-fit:cover;width:100%">
                    <small class="text-muted d-block mt-2">Foto saat ini</small>
                </div>
                <?php endif; ?>
                <input type="file" name="foto_utama" class="form-control mk-input"
                       accept="image/jpeg,image/png,image/webp"
                       <?= $isEdit ? '' : '' ?>>
                <small class="text-muted d-block mt-2">
                    Format: JPG, PNG, WEBP. Maks 2MB.
                    <?= $isEdit ? 'Kosongkan jika tidak ingin mengubah foto.' : '' ?>
                </small>
            </div>


            <div class="mk-admin-card mb-4">
                <h5 class="text-warning mb-4"><i class="bi bi-currency-dollar me-2"></i>Harga Tiket</h5>
                <div class="mb-3">
                    <label class="form-label text-muted small fw-semibold">Weekday (Senin–Kamis)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary text-muted small">Rp</span>
                        <input type="number" name="harga_weekday" class="form-control mk-input"
                               min="0" step="1000" placeholder="0 = Gratis"
                               value="<?= $wisata['harga_weekday'] ?? 0 ?>">
                    </div>
                </div>
                <div>
                    <label class="form-label text-muted small fw-semibold">Weekend (Jumat–Minggu)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary text-muted small">Rp</span>
                        <input type="number" name="harga_weekend" class="form-control mk-input"
                               min="0" step="1000" placeholder="0 = Gratis"
                               value="<?= $wisata['harga_weekend'] ?? 0 ?>">
                    </div>
                </div>
            </div>


            <div class="mk-admin-card mb-4">
                <h5 class="text-warning mb-4"><i class="bi bi-clock me-2"></i>Jam Operasional</h5>
                <div class="row g-3">
                    <div class="col-6">
                        <label class="form-label text-muted small fw-semibold">Buka</label>
                        <input type="time" name="jam_buka" class="form-control mk-input"
                               value="<?= e($wisata['jam_buka'] ?? '18:00') ?>">
                    </div>
                    <div class="col-6">
                        <label class="form-label text-muted small fw-semibold">Tutup</label>
                        <input type="time" name="jam_tutup" class="form-control mk-input"
                               value="<?= e($wisata['jam_tutup'] ?? '22:00') ?>">
                    </div>
                </div>
            </div>


            <div class="mk-admin-card mb-4">
                <h5 class="text-warning mb-3"><i class="bi bi-sliders me-2"></i>Opsi Tampilan</h5>
                <div class="form-check form-switch">
                    <input type="checkbox" name="is_featured" id="isFeatured"
                           class="form-check-input" role="switch"
                           <?= ($wisata['is_featured'] ?? 0) ? 'checked' : '' ?>>
                    <label for="isFeatured" class="form-check-label text-muted">
                        Tampilkan di Beranda (Unggulan)
                    </label>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-warning btn-lg fw-bold">
                    <i class="bi bi-<?= $isEdit ? 'floppy2' : 'plus-circle' ?> me-2"></i>
                    <?= $isEdit ? 'Simpan Perubahan' : 'Tambahkan Wisata' ?>
                </button>
                <a href="<?= BASE_URL ?>/admin/wisata.php" class="btn btn-outline-secondary">
                    Batal
                </a>
            </div>
        </div>
    </div>
</form>
</div>

<?php

$fasilitasJson = json_encode($fasilitasArr ?: ['']);
?>
<script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.js"></script>
<script>
const { createApp } = Vue;
createApp({
    data() {
        return {
            fasilitasList: <?= $fasilitasJson ?>
        };
    },
    methods: {
        tambahFasilitas() {
            this.fasilitasList.push('');
        },
        hapusFasilitas(idx) {
            if (this.fasilitasList.length > 1) {
                this.fasilitasList.splice(idx, 1);
            } else {
                this.fasilitasList[0] = '';
            }
        }
    }
}).mount('#wisataFormApp');
</script>
