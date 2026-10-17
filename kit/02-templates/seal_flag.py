#!/usr/bin/env python3
"""Seal a CBX flag for a practical template (no plain flag in page source).

Usage:
  python3 seal_flag.py "CBX{verb_noun}" "answer one" "answer two" ...

Prints CHECK_HASH and SEALED_FLAG_HEX to paste into the practical template.
The practical normalises every answer the same way (trim, lower case, collapse spaces),
joins them with "|" and uses that string as the key. A wrong answer gives a different key,
so the flag cannot be decoded from the source without solving the lab.
Mirrors cyrb53() in the JS templates exactly.
"""
import sys

M = 0xFFFFFFFF

def imul(a, b):
    return ((a & M) * (b & M)) & M

def cyrb53(s, seed=0):
    h1 = (0xdeadbeef ^ seed) & M
    h2 = (0x41c6ce57 ^ seed) & M
    for ch in s.encode('utf-16-le').decode('utf-16-le'):
        c = ord(ch)
        h1 = imul(h1 ^ c, 2654435761)
        h2 = imul(h2 ^ c, 1597334677)
    h1 = imul(h1 ^ (h1 >> 16), 2246822507) ^ imul(h2 ^ (h2 >> 13), 3266489909)
    h1 &= M
    h2 = imul(h2 ^ (h2 >> 16), 2246822507) ^ imul(h1 ^ (h1 >> 13), 3266489909)
    h2 &= M
    return 4294967296 * (2097151 & h2) + (h1 >> 0)

def norm(a):
    return " ".join(a.strip().lower().split())

def main():
    if len(sys.argv) < 3:
        print(__doc__); sys.exit(1)
    flag = sys.argv[1]
    key = "|".join(norm(a) for a in sys.argv[2:])
    check = format(cyrb53(key, 7), 'x')
    sealed = "".join(format(ord(c) ^ (cyrb53(key, i) % 256), '02x') for i, c in enumerate(flag))
    print("CHECK_HASH      =", check)
    print("SEALED_FLAG_HEX =", sealed)

if __name__ == "__main__":
    main()
