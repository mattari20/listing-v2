# M3-11-05I — Owner confirmation of clean V2 target and preserved backup (2026-11-19)

## Owner-supplied Hostinger evidence

The owner supplied two screenshots on 2026-11-19.

### File Manager screenshot

At `public_html`, the visible entries include:
- `institutes-v2` — newly created directory, displayed as modified about two minutes before screenshot.
- `institutes-v2.000000` — renamed previous directory, displayed as modified about one hour before screenshot.

This confirms the new target folder exists and the renamed previous folder remains present. The screenshot does not show the contents of the new folder, so emptiness is not yet verified.

### Git settings screenshot

Hostinger Advanced → Git displays:
- Repository: `listing-v2`
- GitHub account: `mattari20`
- Branch: `main`
- Root directory: `public_html/institutes-v2`
- Auto-deployment: disabled
- Last deployment: completed manual deployment on 2026-11-19 10:25 (displayed in hPanel)

The screenshot does not show a new deployment after the directory was recreated. It therefore does not establish that the new folder has been populated.

## Deployment decision

Do not click Redeploy and do not re-enable auto-deployment yet.

Hostinger's Git integration deploys the selected repository files into the selected root directory and warns that deployment/repository changes can overwrite target data. Deploying the full Laravel repository to `public_html/institutes-v2` would repeat the current unsafe layout, where application source and vendor/config/storage directories sit under the public web root.

The clean deployment architecture must keep Laravel application source, Composer dependencies, configuration and storage outside `public_html`, exposing only Laravel's public web files under the V2 URL.

## Outstanding prerequisite

Before selecting a private source deployment target, obtain owner-supplied File Manager evidence showing the account home directory immediately above `public_html` and the exact directory path available there. The current screenshots do not show that level.

Also verify:
- whether the new `public_html/institutes-v2` directory is empty;
- whether Hostinger Git can target a private directory outside `public_html`;
- available supported SSH/file-copy permissions for publishing only `public/` into the public V2 folder;
- whether a supported alternative to symlinks is required (symlinks are not assumed available);
- how Hostinger's directory password protection will be retained and verified on the new target.

## Safety status

- Option A is authorized as preparation, preserving the old deployment and data.
- New public target folder exists according to owner screenshot.
- Old deployment folder is preserved under `institutes-v2.000000`.
- Git target is set to `public_html/institutes-v2`.
- Auto-deployment remains OFF.
- No new deployment has been triggered by this work.
- No file deletion, file copy, database migration, DB change, DNS change, V1 change, secret access or hosting plan change has occurred.
- No claim is made that the new folder is empty or that staging is deployed.
