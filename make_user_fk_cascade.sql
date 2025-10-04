ALTER TABLE `role_user`
DROP FOREIGN KEY `fk_role_user_user`;

ALTER TABLE `role_user`
ADD CONSTRAINT `fk_role_user_user`
    FOREIGN KEY (`iduser`)
    REFERENCES `user` (`iduser`)
    ON DELETE CASCADE;

ALTER TABLE `pemilik`
DROP FOREIGN KEY `fk_pemilik_user1`;

ALTER TABLE `pemilik`
ADD CONSTRAINT `fk_pemilik_user1`
    FOREIGN KEY (`iduser`)
    REFERENCES `user` (`iduser`)
    ON DELETE CASCADE;

ALTER TABLE `pet`
DROP FOREIGN KEY `fk_pet_pemilik1`;

ALTER TABLE `pet`
ADD CONSTRAINT `fk_pet_pemilik1`
    FOREIGN KEY (`idpemilik`)
    REFERENCES `pemilik` (`idpemilik`)
    ON DELETE CASCADE;

ALTER TABLE `rekam_medis`
DROP FOREIGN KEY `fk_rekam_medis_pet1`;

ALTER TABLE `rekam_medis`
ADD CONSTRAINT `fk_rekam_medis_pet1`
    FOREIGN KEY (`idpet`)
    REFERENCES `pet` (`idpet`)
    ON DELETE CASCADE;

ALTER TABLE `temu_dokter`
DROP FOREIGN KEY `fk_temu_dokter_pet1`;

ALTER TABLE `temu_dokter`
ADD CONSTRAINT `fk_temu_dokter_pet1`
    FOREIGN KEY (`idpet`)
    REFERENCES `pet` (`idpet`)
    ON DELETE CASCADE;
