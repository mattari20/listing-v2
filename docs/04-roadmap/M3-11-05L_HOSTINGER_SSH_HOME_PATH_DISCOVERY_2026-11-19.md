# M3-11-05L — SSH home-path discovery and corrected inspection target (2026-11-19)

## Owner-provided SSH output

The owner connected successfully to Hostinger SSH. The login banner identifies the account host as `sg-nme-web1278`.

Observed:
- `pwd` returned `/home/u537436044`.
- `$HOME` returned `/home/u537436044`.
- The home listing includes a `domains/` directory.
- `$HOME/public_html` does not exist.
- Consequently, `$HOME/public_html/institutes-v2` does not exist.

The owner's earlier Hostinger File Manager screenshots show a `public_html` directory inside the account's website file view, but this is not the direct child path `/home/u537436044/public_html`. Hostinger commonly places website files under a domain-specific path; the exact path must be confirmed from the `domains/` listing.

## Interpretation

The earlier SSH inspection command assumed an incorrect filesystem path. Do not use `$HOME/public_html` for any subsequent command or deployment operation.

The likely website path is under `$HOME/domains/<domain>/public_html`, but the exact directory name and path are not yet confirmed. Do not assume or hard-code it until the next read-only listing.

The pasted output also appears to contain fragments of multiple commands interleaved with directory listing output, so the next inspection should use short commands one at a time.

## Next read-only inspection

Run:

```bash
echo "=== Domains directory ==="
ls -la "$HOME/domains"

echo "=== Domain directories (one level) ==="
find "$HOME/domains" -mindepth 1 -maxdepth 2 -type d -print
```

After identifying the exact domain directory, run a targeted `ls -ld` and `ls -la` for its `public_html` and V2 target. Do not run a broad recursive find over the entire account.

## Safety

- SSH connection succeeded.
- No filesystem changes were made by the shown commands.
- No credentials or contents of `.api_token`, `.env`, private keys or other secret files were inspected.
- Auto-deployment remains OFF.
- The new V2 target and renamed backup remain as owner-reported; their actual SSH paths are not yet established.
- No deployment, deletion, migration, DB change, DNS change, V1 change or permission change authorized/performed.
