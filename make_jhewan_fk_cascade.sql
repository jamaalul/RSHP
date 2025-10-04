-- To fix the foreign key constraint error when deleting a jenis_hewan,
-- we'll modify the existing foreign keys to automatically cascade deletions.

-- For the `ras_hewan` table:
ALTER TABLE `ras_hewan`
DROP FOREIGN KEY `fk_ras_hewan_jenis_hewan1`;

ALTER TABLE `ras_hewan`
ADD CONSTRAINT `fk_ras_hewan_jenis_hewan1`
    FOREIGN KEY (`idjenis_hewan`)
    REFERENCES `jenis_hewan` (`idjenis_hewan`)
    ON DELETE CASCADE;