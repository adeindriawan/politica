<?php if ( ! defined ('BASEPATH')) exit ('No Direct Script Allowed');

function konversi_detik_ke_jam_digital($waktu)
{
	return gmdate("H:i:s", $waktu);
}