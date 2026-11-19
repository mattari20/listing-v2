# M3-11-05N — Direct SSH verification of V2 target and preserved backup (2026-11-19)

## Owner-provided SSH output

The owner ran read-only directory inspection commands in the active Hostinger SSH session.

Confirmed:
- Account home: `/home/u537436044`.
- Domain document root exists:
  `/home/u537436044/domains/estudent.pk/public_html`
- New V2 target exists:
  `/home/u537436044/domains/estudent.pk/public_html/institutes-v2`
- New V2 target permissions/owner as shown:
  `drwxr-xr-x 2 u537436044 o1007568111`
- New V2 target contents at inspection time: only `.` and `..`; therefore empty.
- Backup directory candidate exists:
  `/home/u537436044/domains/estudent.pk/public_html/institutes-v2.000000`

The `find` output returned both:
- `.../public_html/institutes-v2.000000`
- `.../public_html/institutes-v2`

This confirms both directory names exist. The output does not inspect the backup contents, so it does not establish backup completeness or integrity.

## Deployment readiness interpretation

The public V2 target is now directly confirmed empty and the renamed backup directory is present. The domain document root is directly confirmed.

This does not yet establish a safe deployment architecture. Do not deploy the full Laravel repository to `public_html/institutes-v2`: that would place `app`, `vendor`, `config`, `storage`, `.env` and other private application files beneath the public web root.

The next work is to verify an approved private application directory and a safe method to publish only Laravel's `public/` output into the empty public V2 directory. The account Home marker `DO_NOT_UPLOAD_HERE` remains a reason not to place application files at the account home level without Hostinger confirmation.

## Next read-only capability checks

The following checks may be run only as read-only inspection:
- inspect whether `$HOME/domains/estudent.pk` has an approved private application subdirectory (do not create one);
- inspect current Hostinger Git deployment configuration in hPanel;
- establish whether Hostinger supports a Git target outside the document root and a separate public publishing step without relying on symlinks;
- verify the Hostinger-supported PHP execution and file permissions model for a private source directory.

No copy, move, remove, chmod, chown, Composer, Artisan, migration, DB or deployment command is authorized by this evidence record.

## Safety status

- Owner authorized Option A preparation, preserving the existing deployment and data.
- New V2 public directory confirmed empty by SSH.
- Renamed backup directory confirmed present by SSH; contents/integrity not checked.
- Auto-deployment remains OFF per latest supplied hPanel screenshot.
- No deployment, deletion, file transfer, DB change, migration, DNS change, V1 change, secret access, permission change or extra spend occurred.
