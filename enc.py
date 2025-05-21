from cryptography.hazmat.primitives.ciphers import Cipher, algorithms, modes
from cryptography.hazmat.backends import default_backend
from cryptography.hazmat.primitives import padding
import os

# Simulated "book" text (original ~57 chars × 200 000 = ~11.4 million chars)
book_text = (
    "It was the best of times, it was the worst of times..."
) * 200_000

# Generate a random 16-byte key and IV for AES-128
key = os.urandom(16)
iv  = os.urandom(16)

# PKCS7-pad to a multiple of 16 bytes
padder      = padding.PKCS7(128).padder()
padded_text = padder.update(book_text.encode("utf-8")) + padder.finalize()

# Encrypt with AES-CBC
cipher    = Cipher(algorithms.AES(key), modes.CBC(iv), backend=default_backend())
encryptor = cipher.encryptor()
ciphertext = encryptor.update(padded_text) + encryptor.finalize()

# Decrypt
decryptor       = cipher.decryptor()
decrypted_padded = decryptor.update(ciphertext) + decryptor.finalize()

# Remove padding
unpadder      = padding.PKCS7(128).unpadder()
decrypted_text = unpadder.update(decrypted_padded) + unpadder.finalize()

# Print just the beginnings for sanity check
print("Original Text:\n", book_text[:100], "...\n")
print("Encrypted (hex):\n", ciphertext[:64].hex(), "...\n")
print("Decrypted Text:\n", decrypted_text.decode("utf-8")[:100], "...")
