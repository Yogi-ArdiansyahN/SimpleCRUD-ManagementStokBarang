<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\Supplier;
use Carbon\Carbon;
use Carbon\CarbonTimeZone;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class AdminController extends Controller
{

    function barang()
    {
        try {
            $data = [
                'title' => 'Barang',
                'barangs' => Barang::get(),
                'kategoris' => KategoriBarang::get(),
                'suppliers' => supplier::get(),
            ];

            $data['barangs']->transform(function ($barang) {
                $barang->nama_barang = Crypt::decryptString($barang->nama_barang);
                $barang->kategori->nama_kategori = Crypt::decryptString($barang->kategori->nama_kategori);
                $barang->supplier->nama_supplier = Crypt::decryptString($barang->supplier->nama_supplier);
                $barang->supplier->brand_supplier = Crypt::decryptString($barang->supplier->brand_supplier);
                $barang->harga_jual = Crypt::decryptString($barang->harga_jual);

                if ($barang->harga_modal) {
                    $barang->harga_modal = Crypt::decryptString($barang->harga_modal);
                }

                if (!$barang->stok_barang) {
                } else {
                    $barang->stok_barang = Crypt::decryptString($barang->stok_barang);
                }


                return $barang;
            });
            $data['kategoris']->transform(function ($kategori) {
                $kategori->nama_kategori = Crypt::decryptString($kategori->nama_kategori);
                return $kategori;
            });

            $data['suppliers']->transform(function ($supplier) {
                $supplier->nama_supplier = Crypt::decryptString($supplier->nama_supplier);
                $supplier->brand_supplier = Crypt::decryptString($supplier->brand_supplier);
                return $supplier;
            });

            // dd($data);
            return view('barang', $data);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    function createbarang(Request $request)
    {
        try {
            $request['harga_jual'] = str_replace(".", "", $request['harga_jual']);
            $credentials = $request->validate([
                'nama_barang' => 'required|unique:barangs',
                'supplier_id' => 'required',
                'kategori_id' => 'required',
                'harga_jual' => 'required'
            ]);

            // Sanitasi data sebelum disimpan ke database
            $nama_barang = htmlspecialchars($credentials['nama_barang']);

            $barang = Barang::create([
                'nama_barang' => Crypt::encryptString($nama_barang),
                'supplier_id' => $credentials['supplier_id'],
                'kategori_id' => $credentials['kategori_id'],
                'harga_jual' => Crypt::encryptString($credentials['harga_jual'])
            ]);
            return back()->with('success', 'Berhasil Menambah Barang');
        } catch (Exception $e) {
            // dd($e->getMessage());
            return back()->with('error', 'Gagal Menambah Barang. Isi Form Dengan Benar');
        }
    }

    function updatebarang(Request $request)
    {
        try {
            $request['harga_jual'] = str_replace(".", "", $request['harga_jual']);

            $credentials = $request->validate([
                'nama_barang' => 'required|unique:barangs',
                'supplier_id' => 'required',
                'kategori_id' => 'required',
                'harga_jual' => 'required'
            ]);
            // dd($credentials['harga_jual']);
            $barang = Barang::find($request['id']);

            $barang->update([
                'nama_barang' => Crypt::encryptString($credentials['nama_barang']),
                'supplier_id' => $credentials['supplier_id'],
                'kategori_id' => $credentials['kategori_id'],
                'harga_jual' => Crypt::encryptString($credentials['harga_jual'])
            ]);

            $successMessage = 'Data Barang Berhasil Di Edit';
            return back()->with(['success' => $successMessage]);
        } catch (Exception $e) {
            return back()->with('error', 'Isis Form Data Dengan Benar');
        }
    }

    function pembelian()
    {
        $data = [
            'title' => 'Pembelian',
            'kategoris' => KategoriBarang::get(),
            'suppliers' => Supplier::get(),
            'pembelians' => Pembelian::get(),
            'barang' => Barang::get()
        ];

        $data['pembelians']->transform(function ($pmb) {
            $pmb->barang->nama_barang = Crypt::decryptString($pmb->barang->nama_barang);
            $pmb->barang->kategori->nama_kategori = Crypt::decryptString($pmb->barang->kategori->nama_kategori);
            $pmb->barang->supplier->nama_supplier = Crypt::decryptString($pmb->barang->supplier->nama_supplier);
            $pmb->barang->supplier->brand_supplier = Crypt::decryptString($pmb->barang->supplier->brand_supplier);
            $pmb->harga_beli = Crypt::decryptString($pmb->harga_beli);
            $pmb->jumlah_beli = Crypt::decryptString($pmb->jumlah_beli);
            $pmb->total_harga = Crypt::decryptString($pmb->total_harga);
            return $pmb;
        });

        $data['barang']->transform(function ($brg) {
            $brg->nama_barang = Crypt::decryptString($brg->nama_barang);
            $brg->kategori->nama_kategori = Crypt::decryptString($brg->kategori->nama_kategori);
            $brg->supplier->nama_supplier = Crypt::decryptString($brg->supplier->nama_supplier);
            return $brg;
        });


        // Decrypt data before sending it to the view
        $data['kategoris']->transform(function ($kategori) {
            $kategori->nama_kategori = Crypt::decryptString($kategori->nama_kategori);
            // Add other fields to decrypt if needed
            return $kategori;
        });

        // Dekripsi data Supplier sebelum dikirimkan ke view
        $data['suppliers']->transform(function ($supplier) {
            $supplier->nama_supplier = Crypt::decryptString($supplier->nama_supplier);
            $supplier->brand_supplier = Crypt::decryptString($supplier->brand_supplier);
            // Jika ada kolom lain yang perlu dienkripsi, tambahkan di sini
            return $supplier;
        });

        return view('pembelian', $data);
    }

    function createpembelian(Request $request)
    {
        $timeZone = new CarbonTimeZone('Asia/Jakarta');
        $dateNow = Carbon::now($timeZone);
        try {
            $request['total_harga'] = str_replace(".", "", $request['total_harga']);
            $request['harga_beli'] = str_replace(".", "", $request['harga_beli']);

            $credentials = $request->validate([
                'barang_id' => 'required',
                'supplier_id' => 'required',
                'kategori_id' => 'required',
                'harga_beli' => 'required',
                'jumlah_beli' => 'required',
                'total_harga' => 'required',
            ]);

            $pembelian = Pembelian::create([
                'barang_id' => $credentials['barang_id'],
                'harga_beli' => Crypt::encryptString($credentials['harga_beli']),
                'jumlah_beli' => Crypt::encryptString($credentials['jumlah_beli']),
                'total_harga' => Crypt::encryptString($credentials['total_harga']),
                'tanggal_pembelian' => $dateNow
            ]);

            $barang = Barang::find($request['barang_id']);

            if (!$barang->stok_barang) {
                $barang->update([
                    'stok_barang' => $pembelian->jumlah_beli,
                    'harga_modal' => $pembelian->harga_beli
                ]);
                $successMessage = 'Pembelian Barang Berhasil Dibuat. Stok Barang Otomatis Bertambah';
                return back()->with(['success' => $successMessage]);
            }

            $stkBrg = Crypt::decryptString($barang->stok_barang);
            $stokbrg = intval($stkBrg);

            $jmlStok = $stokbrg + $credentials['jumlah_beli'];

            $barang->update([
                'stok_barang' => Crypt::encryptString($jmlStok),
                'harga_modal' => $pembelian->harga_beli
            ]);

            $successMessage = 'Pembelian Barang Berhasil Dibuat';
            return back()->with(['success' => $successMessage]);
        } catch (Exception $e) {
            return back()->with(['error', 'Pembelian Gagal .Tolong Isi Form Dengan Benar']);
            // dd($e->getMessage());
        }
    }

    function updatepembelian(Request $request)
    {
        try {
            $request['total_harga'] = str_replace(".", "", $request['total_harga']);
            $request['harga_satuan'] = str_replace(".", "", $request['harga_satuan']);
            $request['nama_barang'] = htmlspecialchars($request['nama_barang']);

            // Get the original data from the database
            $pembelian = Pembelian::find($request['id']);

            // Check if any changes have been made to the model attributes
            $changesMade = false;

            if ($request['nama_barang'] !== Crypt::decryptString($pembelian->nama_barang)) {
                $changesMade = true;
            }

            if ($request['kategori_barang_id'] !== $pembelian->kategori_barang_id) {
                $changesMade = true;
            }

            if ($request['supplier_id'] !== $pembelian->supplier_id) {
                $changesMade = true;
            }

            if ($request['harga_satuan'] !== $pembelian->harga_satuan) {
                $changesMade = true;
            }

            if ($request['jumlah_beli'] !== $pembelian->jumlah_beli) {
                $changesMade = true;
            }

            if ($request['total_harga'] !== $pembelian->total_harga) {
                $changesMade = true;
            }

            if ($changesMade) {
                // Validate the request data excluding the current record from unique checks
                $credentials = $request->validate([
                    'nama_barang' => 'required|unique:pembelians,nama_barang,' . $request['id'],
                    'kategori_barang_id' => 'required',
                    'supplier_id' => 'required',
                    'harga_satuan' => 'required',
                    'jumlah_beli' => 'required',
                    'total_harga' => 'required',
                ]);

                // Perform updates
                $pembelian->update([
                    'nama_barang' => Crypt::encryptString($request['nama_barang']),
                    'kategori_barang_id' => $request['kategori_barang_id'],
                    'supplier_id' => $request['supplier_id'],
                    'harga_satuan' => Crypt::encryptString($request['harga_satuan']),
                    'jumlah_beli' => Crypt::encryptString($request['jumlah_beli']),
                    'total_harga' => Crypt::encryptString($request['total_harga']),
                ]);

                $successMessage = "Berhasil Melakukan Edit";
                return back()->with(['success' => $successMessage]);
            } else {
                // No changes were made, just return to the previous page
                return back();
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    // function deletepembelian(Request $request)
    // {
    //     $barang = Pembelian::find($request['id']);
    //     $barang->delete();

    //     return back()->with('success', 'Hapus Data Pembelian Berhasil');
    // }

    function penjualan()
    {
        $data = [
            'title' => 'Penjualan',
            'penjualan' => Penjualan::get(),
            'barang' => Barang::get()
        ];

        $data['penjualan']->transform(function ($penjualann) {
            $penjualann->kategori->nama_kategori = Crypt::decryptString($penjualann->kategori->nama_kategori);
            $penjualann->barang->nama_barang = Crypt::decryptString($penjualann->barang->nama_barang);
            $penjualann->harga = Crypt::decryptString($penjualann->harga);
            $penjualann->jumlah_barang = Crypt::decryptString($penjualann->jumlah_barang);
            $penjualann->total_harga = Crypt::decryptString($penjualann->total_harga);


            return $penjualann;
        });


        $data['barang']->transform(function ($barangs) {
            $barangs->nama_barang = Crypt::decryptString($barangs->nama_barang);
            $barangs->kategori->nama_kategori = Crypt::decryptString($barangs->kategori->nama_kategori);
            $barangs->supplier->nama_supplier = Crypt::decryptString($barangs->supplier->nama_supplier);
            $barangs->supplier->brand_supplier = Crypt::decryptString($barangs->supplier->brand_supplier);
            if ($barangs->harga_jual) {
                $barangs->harga_jual = Crypt::decryptString($barangs->harga_jual);
            }
            if ($barangs->stok_barang) {
                $barangs->stok_barang = Crypt::decryptString($barangs->stok_barang);
            }


            return $barangs;
        });
        return view('penjualan', $data);
    }

    function createpenjualan(Request $request)
    {
        $timeZone = new CarbonTimeZone('Asia/Jakarta');
        $dateNow = Carbon::now($timeZone);


        try {

            $request['total_harga'] = str_replace(".", "", $request['total_harga']);
            $request['harga_jual'] = str_replace(".", "", $request['harga_jual']);

            $credentials = $request->validate([
                'nama_barang' => 'required',
                'kategori_id' => 'required',
                'harga_jual' => 'required',
                'jumlah' => 'required',
                'total_harga' => 'required',
            ]);

            $barang = Barang::find($credentials['nama_barang']);

            $penjualan = Penjualan::create([
                'barang_id' => $credentials['nama_barang'],
                'kategori_id' => $barang->kategori->id,
                'jumlah_barang' => Crypt::encryptString($credentials['jumlah']),
                'harga' => Crypt::encryptString($credentials['harga_jual']),
                'total_harga' => Crypt::encryptString($credentials['total_harga']),
                'tanggal_penjualan' => $dateNow
            ]);

            $brgstk = Crypt::decryptString($barang->stok_barang);
            $jmlbrg = Crypt::decryptString($penjualan->jumlah_barang);
            $stk = intval($brgstk);
            $brg = intval($jmlbrg);
            $stok = $stk - $brg;

            $update_stok = Crypt::encryptString($stok);
            // dd($update_stok);
            $barang->update(['stok_barang' => $update_stok]);

            return back()->with('success', 'Penjualan Berhasil Di Lakukan, Jumlah Stok Akan Otomatis Berkurang');
        } catch (Exception $e) {
            // dd($e->getMessage());
            return back()->with('error', 'Isi Form Penjualan Dengan Benar');
        }
    }

    function deletepenjualan(Request $request)
    {
        $barang = Barang::find($request['barang_id']);
        $penjualan = Penjualan::find($request['id']);

        $brgstok = Crypt::decryptString($barang->jumlah_stok_barang);
        $jmlbrg = Crypt::decryptString($penjualan->jumlah_barang);
        $numberr = intval($jmlbrg);
        $number = intval($brgstok);
        $stok = $number + $numberr;

        $update_stok = Crypt::encryptString($stok);


        $barang->update([
            'jumlah_stok_barang' => $update_stok,
        ]);

        $penjualan->delete();

        return back()->with('success', 'Hapus Data Berhasil, Stok Barang Berubah');
    }

    // function supplier tanpa enkripsi (pembuktian bahwa enkripsi data berhasil)
    // function supplier()
    // {
    //     $data = [
    //         'title' => 'Supplier',
    //         'supplier' => Supplier::get()
    //     ];
    //     return view('supplier', $data);
    // }

    // function supplier dengan enkripsi  
    function supplier()
    {
        $data = [
            'title' => 'Supplier',
            'suppliers' => Supplier::get()
        ];

        // Dekripsi data sebelum dikirimkan ke view
        $data['suppliers']->transform(function ($supplier) {
            $supplier->nama_supplier = Crypt::decryptString($supplier->nama_supplier);
            $supplier->alamat_supplier = Crypt::decryptString($supplier->alamat_supplier);
            $supplier->kontak_supplier = Crypt::decryptString($supplier->kontak_supplier);
            $supplier->brand_supplier = Crypt::decryptString($supplier->brand_supplier);
            return $supplier;
        });

        return view('supplier', $data);
    }
    function createsupplier(Request $request)
    {
        try {
            $request['nama_supplier'] = htmlspecialchars($request['nama_supplier']);
            $request['alamat_supplier'] = htmlspecialchars($request['alamat_supplier']);
            $request['kontak_supplier'] = htmlspecialchars($request['kontak_supplier']);
            $request['brand_supplier'] = htmlspecialchars($request['brand_supplier']);

            $credentials = $request->validate([
                'nama_supplier' => 'required',
                'alamat_supplier' => 'required',
                'kontak_supplier' => 'required',
                'brand_supplier' => 'required'
            ]);

            // Enkripsi data sebelum disimpan
            $encryptedNamaSupplier = Crypt::encryptString($credentials['nama_supplier']);
            $encryptedAlamatSupplier = Crypt::encryptString($credentials['alamat_supplier']);
            $encryptedKontakSupplier = Crypt::encryptString($credentials['kontak_supplier']);
            $encryptedBrandSupplier = Crypt::encryptString($credentials['brand_supplier']);

            Supplier::create([
                'nama_supplier' => $encryptedNamaSupplier,
                'alamat_supplier' => $encryptedAlamatSupplier,
                'kontak_supplier' => $encryptedKontakSupplier,
                'brand_supplier' => $encryptedBrandSupplier
            ]);

            return back()->with('success', 'Tambah Supplier Berhasil');
        } catch (Exception $e) {
            // dd($e->getMessage());
            return back()->with('error', 'Tambah Supplier Gagal, Isi Form Dengan Benar');
        }
    }

    function updatesupplier(Request $request)
    {
        try {
            $request['nama_supplier'] = htmlspecialchars($request['nama_supplier']);
            $request['alamat_supplier'] = htmlspecialchars($request['alamat_supplier']);
            $request['kontak_supplier'] = htmlspecialchars($request['kontak_supplier']);
            $request['brand_supplier'] = htmlspecialchars($request['brand_supplier']);

            $supp = Supplier::find($request['id']);

            $credentials = $request->validate([
                'nama_supplier' => 'required',
                'alamat_supplier' => 'required',
                'kontak_supplier' => 'required',
                'brand_supplier' => 'required'
            ]);

            // Enkripsi data sebelum diupdate
            $encryptedNamaSupplier = Crypt::encryptString($credentials['nama_supplier']);
            $encryptedAlamatSupplier = Crypt::encryptString($credentials['alamat_supplier']);
            $encryptedKontakSupplier = Crypt::encryptString($credentials['kontak_supplier']);
            $encryptedBrandSupplier = Crypt::encryptString($credentials['brand_supplier']);

            $supp->update([
                'nama_supplier' => $encryptedNamaSupplier,
                'alamat_supplier' => $encryptedAlamatSupplier,
                'kontak_supplier' => $encryptedKontakSupplier,
                'brand_supplier' => $encryptedBrandSupplier
            ]);

            return back()->with('success', 'Update Supplier Berhasil');
        } catch (Exception $e) {
            return back()->with('error', 'Update Gagal, Isi Dengan Benar');

            // dd($e->getMessage());
        }
    }


    function kategoribarang()
    {
        $data = [
            'title' => 'Kategori Barang',
            'kategoribarang' => KategoriBarang::get()
        ];

        // Encrypt data before sending it to the view
        $data['kategoribarang']->transform(function ($kategori) {
            $kategori->nama_kategori = Crypt::decryptString($kategori->nama_kategori);
            // Add other fields to encrypt if needed
            return $kategori;
        });

        return view('kategoribarang', $data);
    }

    function createkategori(Request $request)
    {
        try {
            $request['nama_kategori'] = htmlspecialchars($request['nama_kategori']);
            $credentials = $request->validate([
                'nama_kategori' => 'required'
            ]);
            // Encrypt the data before storing it in the database
            $credentials['nama_kategori'] = Crypt::encryptString($credentials['nama_kategori']);

            KategoriBarang::create($credentials);

            // Optionally, you can also encrypt the success message before storing it in the session
            $successMessage = 'Berhasil Menambah Kategori';

            return back()->with('success', $successMessage);
        } catch (Exception $e) {
            return back()->with('error', 'Tolong Isi Dengan Benar');
            // dd($e->getMessage());
        }
    }
}
