# M3-11-05M — Confirmed Hostinger domain document-root path (2026-11-19)

## Owner-provided SSH evidence

The owner successfully ran the following read-only commands in SSH:

```bash
ls -la "$HOME/domains"
find "$HOME/domains" -mindepth 1 -maxdepth 2 -type d -print
```

Observed output:
- `$HOME` is `/home/u537436044`.
- `$HOME/domains/estudent.pk` exists.
- `$HOME/domains/estudent.pk/public_html` exists.
- `$HOME/domains/estudent.pk/.trash` exists.
- `$HOME/domains/estudent.pk/.builds` exists.

Therefore the previously assumed `$HOME/public_html` path was incorrect. The confirmed domain document-root path is:

`/home/u537436044/domains/estudent.pk/public_html`

The expected V2 subfolder path, based on the owner's File Manager screenshots and this confirmed domain root, is:

`/home/u537436044/domains/estudent.pk/public_html/institutes-v2`

The expected path is an inference from the two independent owner-provided views. It still needs a direct SSH `ls -ld` and `ls -la` check before any file operation.

## Next read-only verification

Run:

```bash
echo "=== Domain document root ==="
ls -ld "$HOME/domains/estudent.pk/public_html"

echo "=== New V2 directory ==="
ls -ld "$HOME/domains/estudent.pk/public_html/institutes-v2"

echo "=== New V2 directory contents ==="
ls -la "$HOME/domains/estudent.pk/public_html/institutes-v2"

echo "=== Preserved backup directory candidates ==="
find "$HOME/domains/estudent.pk/public_html" -mindepth 1 -maxdepth 1 -type d -name 'institutes-v2*' -print
```

All commands are read-only. Do not run copy, move, remove, chmod, chown, Composer, Artisan, migration, or deployment commands.

## Safety status

- Hostinger SSH connection successful.
- Correct account home: `/home/u537436044`.
- Confirmed domain root: `/home/u537436044/domains/estudent.pk/public_html`.
- Expected V2 and backup paths are not yet directly verified through SSH.
- Hostinger File Manager previously showed new `institutes-v2` empty and renamed backup `institutes-v2.000000`.
- Git deployment target shown in hPanel is `public_html/institutes-v2`.
- Auto-deployment remains OFF.
- No deployment, deletion, data copy, permissions change, DB operation, migration, DNS change, V1 change, secret access or additional spend occurred.
