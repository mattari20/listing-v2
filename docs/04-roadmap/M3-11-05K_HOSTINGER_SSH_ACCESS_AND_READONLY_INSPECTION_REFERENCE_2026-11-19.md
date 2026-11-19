# Hostinger SSH access reference for V2 staging preparation

Recorded from the owner's Hostinger hPanel SSH Access screenshot supplied on 2026-11-19.

## SSH connection details

- SSH status: ACTIVE (as displayed in hPanel on 2026-11-19)
- Server IP: `185.232.14.237`
- SSH port: `65002`
- SSH username: `u537436044`
- Authentication: Hostinger SSH password configured in hPanel; password is not recorded here.
- Host key fingerprint (ED25519), as displayed in hPanel:
  `SHA256:W9YXwb9g6kNtTQxZvw+/cxOevMUeyw+Y4v4iIc/eHAk`

Treat the fingerprint as a verification value, not as a substitute for checking the server identity. If PowerShell reports a first-connection fingerprint that differs from the current hPanel fingerprint, stop and verify with Hostinger before accepting it.

## Exact Windows PowerShell login command

Open Windows PowerShell or Windows Terminal and run:

```powershell
ssh -p 65002 u537436044@185.232.14.237
```

At the first connection:
1. Compare the displayed ED25519 host fingerprint with the hPanel value above.
2. Only if it matches, type `yes` to trust and save the host key.
3. Enter the SSH password when prompted. Password characters normally do not display while typing.
4. Never paste the SSH password into ChatGPT, GitHub, a repository file or a screenshot.

If PowerShell says that `ssh` is not recognized, check the Windows OpenSSH Client optional feature. Do not install third-party SSH software just for this workflow.

## Read-only V2 path inspection commands

After login succeeds, run these commands one at a time:

```bash
echo "=== Current directory ==="
pwd

echo "=== Home directory ==="
printf '%s\n' "$HOME"

echo "=== Home directory listing ==="
ls -la "$HOME"

echo "=== public_html path ==="
ls -ld "$HOME/public_html"

echo "=== New V2 target ==="
ls -ld "$HOME/public_html/institutes-v2"

echo "=== New V2 target contents ==="
ls -la "$HOME/public_html/institutes-v2"
```

These commands only read path and directory metadata. They do not create, delete, upload, modify permissions, run Composer or Artisan, or deploy.

Share the output with account-specific details redacted if desired. Do not share passwords, private keys, tokens, database credentials or `.env` contents.

## Current deployment safeguards

- Hostinger Git repository: `mattari20/listing-v2`
- Branch shown in hPanel: `main`
- Deployment root shown in hPanel: `public_html/institutes-v2`
- Auto-deployment: OFF (owner-supplied screenshot on 2026-11-19)
- New `public_html/institutes-v2` directory: empty at time of owner screenshot on 2026-11-19
- Previous deployment: preserved in renamed folder `public_html/institutes-v2.000000` as shown in owner screenshot
- No staging deployment or deletion authorized/performed yet.
- Account Home screenshot shows `.builds`, `.trash`, `public_html`, and a `DO_NOT_UPLOAD_HERE` marker. Do not upload application files at account Home level.
- Do not deploy the full Laravel repository into a public web directory. The intended design must keep Laravel source, `vendor`, `config`, `storage` and secrets outside the public document root, exposing only the Laravel `public/` content.

This document records connection metadata and safe inspection instructions only. It does not contain a password or private key.
