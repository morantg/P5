@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../fig-r/psr2r-sniffer/bin/tokenize
sh "%BIN_TARGET%" %*
