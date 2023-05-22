<?php

/**
 * Defined global constants for the app
 *
 * @package Application\Constant
 * @version 1.0.3
 *
 * @since 1.0.0
 */
define('SEME_VERBOSE', true);
if (!defined('CURRENT_RESELLER_SESSION_KEY')) define('CURRENT_RESELLER_SESSION_KEY', 'CURRENT_RESELLER_SESSION_KEY');
if (!defined('DATATABLES_AJAX_FAILED_MSG')) define('DATATABLES_AJAX_FAILED_MSG', '<h4>Error</h4><p>Tidak dapat mengambil data dari server, silakan coba lagi nanti</p>');
if (!defined('DATATABLES_AJAX_FAILED_CLASS')) define('DATATABLES_AJAX_FAILED_CLASS', 'warning');
if (!defined('AJAX_CREATE_SUCCESS_MSG')) define('AJAX_CREATE_SUCCESS_MSG', '<h4>Berhasil</h4><p>Data baru berhasil disimpan</p>');
if (!defined('AJAX_CREATE_SUCCESS_CLASS')) define('AJAX_CREATE_SUCCESS_CLASS', 'success');
if (!defined('AJAX_CREATE_FAILED_CLASS')) define('AJAX_CREATE_FAILED_CLASS', 'danger');
if (!defined('AJAX_CREATE_ERROR_MSG')) define('AJAX_CREATE_ERROR_MSG', '<h4>Error</h4><p>Untuk saat ini tidak dapat menambahkan data baru, silakan coba beberapa saat lagi</p>');
if (!defined('AJAX_CREATE_ERROR_CLASS')) define('AJAX_CREATE_ERROR_CLASS', 'warning');
if (!defined('AJAX_UPDATE_SUCCESS_MSG')) define('AJAX_UPDATE_SUCCESS_MSG', '<h4>Berhasil</h4><p>Pembaruan data berhasil disimpan</p>');
if (!defined('AJAX_UPDATE_SUCCESS_CLASS')) define('AJAX_UPDATE_SUCCESS_CLASS', 'success');
if (!defined('AJAX_UPDATE_FAILED_CLASS')) define('AJAX_UPDATE_FAILED_CLASS', 'danger');
if (!defined('AJAX_UPDATE_ERROR_MSG')) define('AJAX_UPDATE_ERROR_MSG', '<h4>Error</h4><p>Untuk saat ini tidak dapat memperbarui data, silakan coba beberapa saat lagi</p>');
if (!defined('AJAX_UPDATE_ERROR_CLASS')) define('AJAX_UPDATE_ERROR_CLASS', 'warning');
if (!defined('AJAX_DELETE_SUCCESS_MSG')) define('AJAX_DELETE_SUCCESS_MSG', '<h4>Berhasil</h4><p>Data berhasil dihapus</p>');
if (!defined('AJAX_DELETE_SUCCESS_CLASS')) define('AJAX_DELETE_SUCCESS_CLASS', 'success');
if (!defined('AJAX_DELETE_FAILED_CLASS')) define('AJAX_DELETE_FAILED_CLASS', 'danger');
if (!defined('AJAX_DELETE_ERROR_MSG')) define('AJAX_DELETE_ERROR_MSG', '<h4>Error</h4><p>Tidak dapat melakukan penghapusan data sekarang, coba lagi nanti</p>');
if (!defined('AJAX_DELETE_ERROR_CLASS')) define('AJAX_DELETE_ERROR_CLASS', 'warning');
if (!defined('AJAX_DELETE_CONFIRM_MSG')) define('AJAX_DELETE_CONFIRM_MSG', 'Data ini akan dihapus, yakin?');

if (!defined('USER_DEFAULT_IMAGE')) define('USER_DEFAULT_IMAGE', 'media/user-default.png');

if (!defined('API_ADMIN_ERROR_CODES')) {
    define('API_ADMIN_ERROR_CODES', [
        104 => 'SKU sudah digunakan',
        200 => 'OK',
        204 => 'No content',
        400 => 'Harus login',
        401 => 'Harus login',
        404 => 'Not found',
        414 => 'Data with supplied ID is not exists',
        428 => 'Referrence ID is invalid',
        444 => 'One or more parameter are required',
        445 => 'Data with supplied ID not found',
        520 => 'Invalid ID',
        521 => 'ID tidak ditemukan atau telah dihapus',
        522 => 'Data tidak ditemukan atau telah dihapus',
        523 => 'Invalid APIKEY',
        900 => 'Tidak dapat menambahkan data baru',
        901 => 'Tidak dapat melakukan perubahan ke basis data',
        902 => 'Tidak dapat melakukan penghapusan data',
        1444 => 'One or more parameter are required for reseller operation',
        1718 => 'It looks like the email you entered is incorrect, please check again',
        1719 => 'It looks like the email you entered is incorrect, please check again',
        1900 => 'Tidak dapat menambahkan data reseller baru',
        1901 => 'Tidak dapat merubah data reseller',
        1902 => 'Tidak dapat menghapus data reseller',
        2444 => 'One or more parameter are required for reseller owner',
        2900 => 'Tidak dapat menambahkan data pemilik reseller baru',
        2901 => 'Tidak dapat merubah data pemilik reseller',
        2902 => 'Tidak dapat menghapus data pemilik reseller',
        2104 => 'Email pemilik reseller telah digunakan',
        3900 => 'Tidak dapat menambahkan data alamat baru',
        3901 => 'Tidak dapat merubah data alamat',
        3902 => 'Tidak dapat menghapus data alamat',
    ]);
}
if (!defined('API_ADMIN_SUCCESS_MESSAGES')) {
    define('API_ADMIN_SUCCESS_MESSAGES', [
        'edit' => 'Perubahan data berhasil disimpan!',
    ]);
}
if (!defined('API_ADMIN_ERROR_MESSAGES')) {
    define('API_ADMIN_ERROR_MESSAGES', [
        'edit' => 'Proses edit data tidak bisa dilakukan, coba beberapa saat lagi',
        'datatable' => 'Tidak dapat mengambil data dari server, cobalah beberapa saat lagi',
    ]);
}
