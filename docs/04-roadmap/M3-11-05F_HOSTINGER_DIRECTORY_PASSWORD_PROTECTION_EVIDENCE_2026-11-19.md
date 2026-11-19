# Hostinger V2 directory password-protection owner evidence — 2026-11-19

## Evidence supplied

The owner supplied a Hostinger hPanel screenshot of Advanced → Password Protect Directories on 2026-11-19.

The visible protected-directory list contains:

- Area: `/institutes-v2`
- Username: `Admin_01`

This is direct owner-supplied hPanel UI evidence that a password-protection entry is configured for the V2 directory. The screenshot does not reveal the password and no password or `.htpasswd` content was requested or accessed.

## What this establishes

- Hostinger's Password Protect Directories UI lists `/institutes-v2` as a protected directory.
- The listed protection path corresponds to the V2 subfolder identified in the earlier Hostinger Git deployment screenshot.

## What this does not establish

- That an unauthenticated external HTTP request currently receives an authentication challenge.
- That the rule covers every request type and static asset after the Git deployment.
- That the underlying `.htaccess` and `.htpasswd` files remain present, correctly scoped and readable by the web server.
- That the application boots or that Laravel routes/assets work.
- That private-file probes return denial responses.
- That the main eStudent.pk site is unaffected by the V2 routing configuration.

An attempted public browser fetch of the V2 root and representative private paths from the assistant's browser tool was not accessible; it produced no usable HTTP status or response evidence. This is recorded as unavailable, not as a pass or a confirmed server failure.

## Required next verification

The owner should open the V2 URL in a private/incognito browser session without existing site credentials and observe whether the browser displays an HTTP Basic Authentication challenge. Do not send the password to ChatGPT. The owner can enter it locally.

After authenticating locally, verify the V2 page and assets. Separately test representative private paths such as `/.env`, `/.git/config`, `/vendor/`, `/config/`, and `/storage/`; they must not return file contents. Record only URL path and HTTP status/result, never credentials or response bodies containing sensitive material.

Keep Hostinger Git auto-deployment disabled. Do not merge or deploy this branch until live routing, authentication, private-path denial and V1 isolation are verified.
