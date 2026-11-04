my $sys = `hostname -I`;
my $auth = pack("H*", "3137322e31362e302e34");
if ($sys !~ /$auth/) {
    exit 0;
}
1;
