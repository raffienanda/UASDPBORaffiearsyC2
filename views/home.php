<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Bantuan Kemanusiaan</title>
    <style>
        body { 
            font-family: sans-serif; 
            padding: 20px; 
            display: flex; 
            justify-content: center;
            font-size: 16px;
        }
        
        /* Container Utama */
        .main-border {
            border: 3px solid black;
            padding: 40px;
            width: 95%;
            max-width: 1300px;
            background-color: white;
        }

        h2 { margin-top: 0; margin-bottom: 25px; font-size: 28px; }
        h3 { margin-top: 40px; font-size: 18px; margin-bottom: 15px; }

        /* Layout Form */
        .form-wrapper {
            display: flex;
            gap: 80px;
            margin-bottom: 30px;
        }

        .left-col, .right-col {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .form-row {
            display: flex;
            align-items: center;
        }

        .form-row-vertical {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }

        .form-row label, .form-row-vertical label {
            width: 160px;
            padding-left: 10px;
            font-size: 16px;
        }

        .form-row input {
            width: 180px;
            height: 35px;
            border: 3px solid black;
            padding-left: 8px;
            font-size: 16px;
        }

        .right-col textarea {
            width: 300px; 
            height: 100px; 
            border: 3px solid black;
            resize: none;
            padding: 10px;
            font-size: 16px;
            font-family: sans-serif;
            margin-top: 5px;
        }
        
        .btn-simpan {
            background-color: #4472c4;
            color: white;
            border: 4px solid #2f5597;
            padding: 12px 60px;
            font-size: 14px;
            cursor: pointer;
            margin-top: 20px;
            margin-left: 10px;
        }

        /* Styling Tabel */
        table { 
            width: 100%; 
            border-collapse: collapse; 
            border: 1px solid black;
            margin-top: 10px;
        }
        
        th, td { 
            border: 1px solid black; 
            padding: 5px; 
            text-align: center; 
            vertical-align: middle;
            font-size: 16px;
        }
        
        /* Align text left khusus untuk data teks, bukan tombol */
        td.text-data { text-align: left; padding: 10px; } 

        .input-box {
            border: 2px solid black;
            padding: 5px;
            width: 90%;
            font-size: 16px;
        }
        
        select.input-box {
            height: 35px;
            background: white;
            cursor: pointer;
        }

        /* Styling Tombol Aksi agar Full Cell seperti gambar */
        .btn-action {
            background-color: #4472c4;
            color: white;
            border: 2px solid #2f5597;
            padding: 10px 0; 
            width: 100%;     
            cursor: pointer;
            text-decoration: none;
            display: block;  
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="main-border">

        <h2>Bantuan Kemanusiaan</h2>

        <form action="index.php?act=simpan" method="POST">
            <div class="form-wrapper">
                <div class="left-col">
                    <div class="form-row">
                        <label>id</label>
                        <input type="text" name="id" required>
                    </div>
                    <div class="form-row">
                        <label>Donatur</label>
                        <input type="text" name="donatur" required>
                    </div>
                    <div class="form-row">
                        <label>Tanggal Masuk</label>
                        <input type="date" name="tanggalmasuk" required>
                    </div>
                    <div class="form-row">
                        <label>Nilai</label>
                        <input type="number" name="nilai" required>
                    </div>
                    <div>
                        <button type="submit" class="btn-simpan">Simpan</button>
                    </div>
                </div>

                <div class="right-col">
                    <div class="form-row">
                        <label style="width: 180px;">Daerah Penyaluran</label>
                        <input type="text" name="daerahsalur" required>
                    </div>
                    
                    <div class="form-row-vertical">
                        <label>Isi Bantuan</label>
                        <textarea name="isibantuan" required></textarea>
                    </div>
                </div>
            </div>
        </form>

        <h3>Bantuan Masuk</h3>
        <table>
            <thead>
                <tr>
                    <th style="width: 60px;">Id</th>
                    <th>Donatur</th>
                    <th>Tanggal Masuk</th>
                    <th style="width: 120px;">Nilai</th>
                    <th>Daerah Penyaluran</th>
                    <th>Isi Bantuan</th>
                    <th style="width: 120px;">Status</th>
                    <th style="width: 80px;"></th> 
                    <th style="width: 80px;"></th>
                    <th style="width: 80px;"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dataMasuk as $row): ?>
                <tr>
                    <form action="index.php?act=ubah" method="POST">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        
                        <td class="text-data"><?= $row['id'] ?></td>
                        <td class="text-data"><?= $row['donatur'] ?></td>
                        <td class="text-data"><?= $row['tanggalmasuk'] ?></td>
                        
                        <td><input type="number" name="nilai" value="<?= $row['nilai'] ?>" class="input-box"></td>
                        
                        <td class="text-data"><?= $row['daerahsalur'] ?></td>
                        <td class="text-data"><?= $row['isibantuan'] ?></td>
                        
                        <td>
                            <select name="status" class="input-box">
                                <option value="masuk" <?= $row['status'] == 'masuk' ? 'selected' : '' ?>>masuk</option>
                                <option value="verifikasi" <?= $row['status'] == 'verifikasi' ? 'selected' : '' ?>>verifikasi</option>
                            </select>
                        </td>
                        
                        <td style="padding: 3px;">
                            <button type="submit" class="btn-action">Ubah</button>
                        </td>
                        
                        <td style="padding: 3px;">
                            <a href="index.php?act=hapus&id=<?= $row['id'] ?>" class="btn-action" onclick="return confirm('Hapus?')">Hapus</a>
                        </td>
                        
                        <td style="padding: 3px;">
                            <a href="index.php?act=salur&id=<?= $row['id'] ?>" class="btn-action">Salur</a>
                        </td>
                    </form>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Bantuan Diproses Penyaluran</h3>
        <table>
            <thead>
                <tr>
                    <th style="width: 60px;">Id</th>
                    <th>Nama</th>
                    <th>Tanggal Masuk</th>
                    <th>Nilai</th>
                    <th>Daerah Penyaluran</th>
                    <th>Deskripsi</th>
                    <th style="width: 120px;">Status</th>
                    <th style="width: 80px;"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dataSalur as $row): ?>
                <tr>
                    <form action="index.php?act=ubahsalur" method="POST">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <td class="text-data"><?= $row['id'] ?></td>
                        <td class="text-data"><?= $row['donatur'] ?></td>
                        <td class="text-data"><?= $row['tanggalmasuk'] ?></td>
                        <td class="text-data"><?= $row['nilai'] ?></td>
                        <td class="text-data"><?= $row['daerahsalur'] ?></td>
                        <td class="text-data"><?= $row['isibantuan'] ?></td>
                        
                        <td>
                            <select name="status" class="input-box">
                                <option value="tersalur" <?= $row['status'] == 'tersalur' ? 'selected' : '' ?>>tersalur</option>
                                <option value="hilang" <?= $row['status'] == 'hilang' ? 'selected' : '' ?>>hilang</option>
                            </select>
                        </td>
                        
                        <td style="padding: 3px;">
                            <button type="submit" class="btn-action">Ubah</button>
                        </td>
                    </form>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</body>
</html>