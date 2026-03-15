<?php

return [

    'noRuleSets'            => 'Tidak ada kumpulan aturan (rule set) yang ditentukan dalam konfigurasi validasi.',
    'ruleNotFound'          => 'Aturan {0} tidak ditemukan.',
    'groupNotFound'         => 'Grup validasi {0} tidak ditemukan.',
    'groupNotArray'         => 'Grup validasi {0} harus berupa array.',
    'invalidTemplate'       => 'Template validasi {0} bukan template yang valid.',

    // Rules (disesuaikan dengan kebutuhan)
    'required'              => '{field} wajib diisi.',
    'valid_email'           => '{field} harus berisi email yang valid.',
    'is_unique'             => '{field} sudah terdaftar, silakan gunakan yang lain.',
    'numeric'               => '{field} hanya boleh berisi angka.',
    'min_length'            => '{field} minimal harus terdiri dari {param} karakter.',
    'max_length'            => '{field} tidak boleh lebih dari {param} karakter.',
    'regex_match'           => '{field} tidak sesuai format yang diizinkan (harus diawali dengan 08).',
    'permit_empty'          => '{field} boleh dikosongkan.',
    'in_list'               => '{field} harus salah satu dari: {param}.',

    // Tambahan umum
    'alpha'                 => '{field} hanya boleh berisi huruf.',
    'alpha_numeric'         => '{field} hanya boleh berisi huruf dan angka.',
    'alpha_numeric_space'   => '{field} hanya boleh berisi huruf, angka, dan spasi.',
    'alpha_dash'            => '{field} hanya boleh berisi huruf, angka, underscore dan strip.',
    'valid_url'             => '{field} harus berupa URL yang valid.',
    'valid_ip'              => '{field} harus berupa alamat IP yang valid.',
    'valid_base64'          => '{field} harus berupa string base64 yang valid.',
    'valid_json'            => '{field} harus berupa JSON yang valid.',

    // Opsional
    'matches'               => '{field} harus sama dengan {param}.',
    'differs'               => '{field} harus berbeda dari {param}.',
    'greater_than'          => '{field} harus lebih besar dari {param}.',
    'greater_than_equal_to' => '{field} harus lebih besar atau sama dengan {param}.',
    'less_than'             => '{field} harus kurang dari {param}.',
    'less_than_equal_to'    => '{field} harus kurang atau sama dengan {param}.',
    // Default
    'noRuleSets'            => 'Tidak ada rule set yang ditentukan dalam konfigurasi Validasi.',
    'ruleNotFound'          => 'Rule {0} tidak ditemukan.',
    'groupNotFound'         => 'Grup validasi {0} tidak ditemukan.',
    'groupNotArray'         => 'Grup validasi {0} harus berupa array.',
    'invalidTemplate'       => 'Template validasi {0} bukan template yang valid.',

    // Rules
    'required'              => '{field} wajib diisi.',
    'matches'               => '{field} harus sama dengan {param}.',
    'differs'               => '{field} harus berbeda dengan {param}.',
    'isUnique'              => '{field} sudah digunakan.',
    'maxLength'             => '{field} tidak boleh lebih dari {param} karakter.',
    'minLength'             => '{field} minimal terdiri dari {param} karakter.',
    'exactLength'           => '{field} harus terdiri dari {param} karakter.',
    'inList'                => '{field} harus salah satu dari: {param}.',
    'notInList'             => '{field} tidak boleh salah satu dari: {param}.',
    'numeric'               => '{field} harus berupa angka.',
    'integer'               => '{field} harus berupa bilangan bulat.',
    'decimal'               => '{field} harus berupa angka desimal.',
    'greaterThan'           => '{field} harus lebih besar dari {param}.',
    'greaterThanEqualTo'    => '{field} harus lebih besar atau sama dengan {param}.',
    'lessThan'              => '{field} harus kurang dari {param}.',
    'lessThanEqualTo'       => '{field} harus kurang atau sama dengan {param}.',
    'equals'                => '{field} harus sama dengan {param}.',
    'notEquals'             => '{field} tidak boleh sama dengan {param}.',

    // Files
    'uploaded'              => '{field} wajib diunggah.',
    'maxSize'               => '{field} melebihi ukuran maksimal {param}.',
    'isImage'               => '{field} harus berupa gambar.',
    'mimeIn'                => '{field} harus bertipe: {param}.',
    'extIn'                 => '{field} harus memiliki ekstensi: {param}.',
    'maxDims'               => '{field} melebihi dimensi maksimum lebar/tinggi yang diizinkan.',

    // Custom
    'validEmail'            => '{field} harus berisi alamat email yang valid.',
    'regexMatch'            => '{field} tidak sesuai format yang diizinkan.',
    'alpha'                 => '{field} hanya boleh berisi huruf.',
    'alphaNumeric'          => '{field} hanya boleh berisi huruf dan angka.',
    'alphaNumericSpace'     => '{field} hanya boleh berisi huruf, angka, dan spasi.',
    'alphaDash'             => '{field} hanya boleh berisi huruf, angka, garis bawah dan strip.',
    'validURL'              => '{field} harus URL yang valid.',
    'validBase64'           => '{field} harus berisi string base64 yang valid.',
    'validJSON'             => '{field} harus berisi JSON yang valid.',
    'validIPAddress'        => '{field} harus berisi alamat IP yang valid.',
    'validIPv4'             => '{field} harus berisi alamat IPv4 yang valid.',
    'validIPv6'             => '{field} harus berisi alamat IPv6 yang valid.',
    'boolean'               => '{field} harus berupa true atau false.',
    'timezone'              => '{field} harus zona waktu yang valid.',
];
