@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../fig-r/psr2r-sniffer/bin/sniff
sh "%BIN_TARGET%" %*
