<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Data Mining</title>
</head>
<body>

  <?php

  error_reporting(E_ALL ^ E_NOTICE);

  include_once 'src/kmeans.php';
  $proses = new Kmeans\Proses;

  $data = [
    ['nama_penyakit' => 'Penyakit A', 0, 0, 0], ['nama_penyakit' => 'Penyakit B', 1, 1, 3], ['nama_penyakit' => 'Penyakit C', 1, 3, 2], ['nama_penyakit' => 'Penyakit D', 1, 4, 1]
  ];

  ?>

  <!-- tabel data yang akan diproses -->
  <h2>Himpunan Data Penderita Penyakit</h2>

  <table border="1">
    <thead>
      <tr>
        <th>No</th>
        <th>Obyek</th>
        <th>A</th>
        <th>B</th>
        <th>C</th>
      </tr>
    </thead>
    <tbody align="center">

      <?php

      $no = 1;

      foreach ($data as $key => $value) {

        echo "<tr>";
        echo "<td>".$no++."</td>";
        echo "<td>".$value['nama_penyakit']."</td>";
        echo "<td width='30px'>".$value[0]."</td>";
        echo "<td width='30px'>".$value[1]."</td>";
        echo "<td width='30px'>".$value[2]."</td>";
        echo "</tr>";

      }

      ?>

    </tbody>
  </table>
  <!-- tabel data yang akan diproses -->

  <h2>Inisialisasi atau Penentuan Centroid</h2>

  <!-- untuk penentuan centroid atau inisialisasi -->
  <table border="1">
    <thead>
      <tr>
        <th>Centroid</th>
        <th>A</th>
        <th>B</th>
        <th>C</th>
      </tr>
    </thead>
    <tbody align="center">
      <?php

      /*
      fungsi untuk menentukan berapa jumlah centroid awal
      dan proses pengambilannya secara acak
      */
      $centroid = $proses->CentroidAwal($data, 3);
      $c = 1;

      foreach ($centroid as $key => $value) {

        echo "<tr>";
          echo "<td>c".$c++."</td>";
          for ($i = 0; $i < count($centroid); $i++) {
            echo "<td width='30px'>".$value[$i]."</td>";
          }
          echo "</tr>";

        }

        ?>
      </tbody>
    </table>
    <!-- untuk penentuan centroid atau inisialisasi -->

    <?php

    $iterasi = 1;
    while (true) {

      // variabel untuk menentukan masuk pada kelompok apa
      $cluster1 = 1;
      $cluster2 = 2;
      $cluster3 = 3;

      /* cara ini untuk mengubah data menjadi array atau mengambil data secara berurut pada kolom
      */
      // variabel array untuk jumlah kolom yang ada pada himpunan data
      $k1 = [];
      $k2 = [];
      $k3 = [];

      // variabel array untuk jumlah centroid
      $cnt1 = [];
      $cnt2 = [];
      $cnt3 = [];

      // mengambil hasil dari perhitungan persamaan ED dan mangambil hasil perhitungan
      $hasil_iterasi = $proses->RumusPersamaanED($data, $centroid);

      // untuk mengambil data dari himpunan data
      foreach ($data as $key1 => $value1) {

        $k1[] = $value1[0];
        $k2[] = $value1[1];
        $k3[] = $value1[2];

      }

      // hasil dari proses perhitungan
      foreach ($hasil_iterasi as $key2 => $value2) {

        $cnt1[] = $value2[0];
        $cnt2[] = $value2[1];
        $cnt3[] = $value2[2];

      }

      // mengubah data menjadi array hasil centroid
      $cluster = [$cnt1, $cnt2, $cnt3];

      // untuk mengambil hasil dari cluster
      $cls = [];

      // manampilkan data pada hasil iterasi
      for ($i=0; $i < count($data); $i++) {

        // untuk proses pembagian cluster
        if ($cnt1[$i] < $cnt2[$i] && $cnt1[$i] < $cnt3[$i]) {

          $cls[] = $cluster1;

        } else if ($cnt2[$i] < $cnt1[$i] && $cnt2[$i] < $cnt3[$i]) {

          $cls[] = $cluster2;

        } else if ($cnt3[$i] < $cnt1[$i] && $cnt3[$i] < $cnt2[$i]) {

          $cls[] = $cluster3;

        }

      }

      // mengambil hasil untuk menentukan nilai terkecil atau jarak terdekat pada hasil cluster
      $hasil_minimal = $proses->NilaiTerkecil($cluster, $data);

      // untuk mengeksekusi apa bila terdapat nilai 0 pada index pertam
      if (!$k1[0] != 0) {
        $k1[0] = sprintf("%02d", 0);
      }

      if (!$k2[0] != 0) {
        $k2[0] = sprintf("%02d", 0);
      }

      if (!$k3[0] != 0) {
        $k3[0] = sprintf("%02d", 0);
      }

      /* mulai proses pencarian nilai rata - rata dari hasil pengelompokan untuk mengambil nilai yang masuk pada cluster */
      // kolom a
      $c1 = [];
      $c2 = [];
      $c3 = [];
      // kolom b
      $d1 = [];
      $d2 = [];
      $d3 = [];
      // kolom c
      $e1 = [];
      $e2 = [];
      $e3 = [];

      // untuk menentukan apa bila ada nilai yang memiliki cluster yang sama pada saat pembagian cluster
      for ($j=0; $j < count($cls); $j++) {

        // menampilkan data menjadi 1
        for ($i=0; $i < 1; $i++) {

          // kolom 1 pada a
          if ($k1[$i] AND $cls[$j] == 1) {
            $c1[] = $k1[$j];
          } else if ($k1[$i] AND $cls[$j] == 2) {
            $c2[] = $k1[$j];
          } else if ($k1[$i] AND $cls[$j] == 3) {
            $c3[] = $k1[$j];
          }

          // kolom 2 pada b
          if ($k2[$i] AND $cls[$j] == 1) {
            $d1[] = $k2[$j];
          } else if ($k2[$i] AND $cls[$j] == 2) {
            $d2[] = $k2[$j];
          } else if ($k2[$i] AND $cls[$j] == 3) {
            $d3[] = $k2[$j];
          }

          // kolom 3 pada c
          if ($k3[$i] AND $cls[$j] == 1) {
            $e1[] = $k3[$j];
          } else if ($k3[$i] AND $cls[$j] == 2) {
            $e2[] = $k3[$j];
          } else if ($k3[$i] AND $cls[$j] == 3) {
            $e3[] = $k3[$j];
          }

        }
        // menampilkan data menjadi 1

      }

      // hasil penyamaan atara cluster dan data
      $cluster = [
      [$c1, $c2, $c3],
      [$d1, $d2, $d3],
      [$e1, $e2, $e3]
      ];

      // untuk mengambil hasil nilai rata rata
      $nilai_rata = $proses->NilaiRatarata($cluster);

      $nilrat1 = [];
      $nilrat2 = [];
      $nilrat3 = [];

      foreach ($nilai_rata as $key => $value) {

        $nilrat1[] = $value[0];
        $nilrat2[] = $value[1];
        $nilrat3[] = $value[2];

      }

      // hasil centroid baru
      $centroid_baru = [$nilrat1, $nilrat2, $nilrat3];

      // untuk mengambil hasil centroid baru
      $centroid = $proses->CentroidBaru($centroid_baru);

      $hasil_baru = [];

      $tabel_iterasi = array();

      // untuk mengambil data
      foreach ($data as $key => $value) {
        // untuk mengambil data berdasarkan baris
        $tabel_iterasi[$key]['data'] = $value;
      }

      // untuk mengambil hasil centroid c1, c2, c3
      foreach ($hasil_iterasi as $key => $value) {
        // untuk mengambil jarak centroid
        $tabel_iterasi[$key]['jarak_centroid'] = $value;
      }

      // untuk mengambil nilai terkecil atau jarak terdekat
      foreach ($hasil_minimal as $key => $value) {
        // untuk mengambil jarak centroid
        $tabel_iterasi[$key]['jarak_terdekat'] = $value;
      }

      // untuk mengambil cluster
      foreach ($cls as $key => $value) {
        // untuk mengambil clustering
        $tabel_iterasi[$key]['cluster'] = $value;
      }

      // untuk mengambil pembagian class pada penyakit
      $hasil_class = array();
      foreach ($tabel_iterasi as $key => $value) {
        for ($i = 1; $i <= count($centroid); $i++) {
          if ($value['data']['nama_penyakit'] AND $value['cluster'] == $i) {
            $hasil_class[$key]["class".$i] = $value['data']['nama_penyakit'];
          }
        }
      }

      // untuk menggabungkan kedua array
      array_push($hasil_baru, $tabel_iterasi);

      ?>

      <!-- untuk menampikan data -->
      <?php foreach ($hasil_baru as $key => $value): ?>

        <h2>Iterasi Ke-<?php echo $iterasi++ ?></h2>
        <!-- menampilkan hasil iterasi -->
        <table border="1">
          <thead>
            <tr>
              <th rowspan="2">No</th>
              <th rowspan="2">Obyek</th>
              <th rowspan="2">A</th>
              <th rowspan="2">B</th>
              <th rowspan="2">C</th>
              <th colspan="3">Jarak Terdekat</th>
              <th rowspan="2">Nilai Terkecil</th>
              <th rowspan="2">Cluster</th>
            </tr>
            <tr>
              <th>C1</th>
              <th>C2</th>
              <th>C3</th>
            </tr>

          </thead>
          <tbody align="center">

            <?php $no = 1 ?>

            <?php foreach ($value as $key1 => $value1): ?>
              <tr>
                <td width="30px"><?php echo $no++; ?></td>
                <td width="100px"><?php echo $value1['data']['nama_penyakit']; ?></td>
                <td width="30px"><?php echo $value1['data'][0]; ?></td>
                <td width="30px"><?php echo $value1['data'][1]; ?></td>
                <td width="30px"><?php echo $value1['data'][2]; ?></td>
                <td width="30px"><?php echo $value1['jarak_centroid'][0]; ?></td>
                <td width="30px"><?php echo $value1['jarak_centroid'][1]; ?></td>
                <td width="30px"><?php echo $value1['jarak_centroid'][2]; ?></td>
                <td width="30px"><?php echo $value1['jarak_terdekat']; ?></td>
                <td width="30px"><?php echo $value1['cluster']; ?></td>
              </tr>
            <?php endforeach; ?>

          </tbody>
        </table>
        <!-- untuk menampilkan tabel -->

      <?php endforeach; ?>

      <h2>Mencari Nilai Rata - rata</h2>
      <!-- tabel untuk mencari nilai rata -->
      <table border="1">
        <thead>
          <tr>
            <th>Centroid</th>
            <th>A</th>
            <th>B</th>
            <th>C</th>
          </tr>
        </thead>
        <tbody align="center">

          <?php $c = 1 ?>

          <!-- menampilkan hasil nilai rata dan centroid baru -->
          <?php foreach ($centroid_baru as $key => $value): ?>
            <tr>
              <td><?php echo $c++; ?></td>
              <td><?php echo $value[0]; ?></td>
              <td><?php echo $value[1]; ?></td>
              <td><?php echo $value[2]; ?></td>
            </tr>
          <?php endforeach; ?>

        </tbody>
      </table>
      <!-- tabel untuk mencari nilai rata -->

      <?php

      // memanggil function cluster baru
      $cluster_baru = $proses->ClusterBaru($cls, $iterasi);

      if (!$cluster_baru) {

        // berhenti
        break;

      }

    }

    ?>

    <h2>Pembagian Cluster Penyakit</h2>
    <!-- tabal untuk pembagian cluster penyakit -->
    <table border="1">
      <thead>
        <tr>
          <th>c1</th>
          <th>c2</th>
          <th>c3</th>
        </tr>
      </thead>
      <tbody>
        <?php

        foreach ($hasil_class as $key => $value) {
          echo "<tr>";
            for ($i = 1; $i <= count($centroid); $i++) {
          echo empty($value["class".$i]) ? "<td align='center'> - </td>" : "<td>".str_replace("_", " ", $value["class".$i])."</td>";
            }
            echo "</tr>";
          }
          ?>

        </tbody>
      </table>
      <!-- pembagian untuk cluster pembagian penyakit -->

</body>
</html>
