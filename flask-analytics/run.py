from app import create_app

app = create_app()

if __name__ == "__main__":
    # you can also read host/port from env if you like
    app.run(host="0.0.0.0", port=5000, debug=True)
