<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print BIB</title>
    <style>
.div {
  display: flex;
  flex-direction: column;
  overflow: hidden;
  position: relative;
  width: 200mm; /* Set width to 200mm */
  height: 145mm; /* Set height to 145mm */
  padding-top: 10mm; /* Adjust padding or margins as needed */
  align-items: center;
  color: #fff;
}

/* Adjust other styles as per your layout requirements */
.img {
  position: absolute;
  inset: 0;
  width: 200mm; /* Sesuaikan dengan ukuran yang diinginkan */
  height: 145mm; /* Sesuaikan dengan ukuran yang diinginkan */
  object-fit: cover;
  object-position: center;
}


  .div-2 {
    position: relative;
    display: flex;
    width: 100%;
    max-width: 1102px;
    gap: 20px;
    font-size: 24px;
    justify-content: space-between;
  }

  .div-3 {
    display: flex;
    flex-direction: column;
    padding: 0 20px;
  }
  .div-4 {
    font-family: Inter, sans-serif;
    font-weight: 400;
    font-size: 32px;
    align-self: center;
  }
  .div-5 {
    font-family: Inter, sans-serif;
    font-weight: 700;
    font-size: 32px;
    margin-top: 12px;
  }
  .div-6 {
    display: flex;
    flex-direction: column;
    padding: 0 20px;
  }
  .div-7 {
    font-family: Inter, sans-serif;
    font-weight: 400;
    font-size: 32px;
    align-self: center;
  }
  .div-8 {
    font-family: Inter, sans-serif;
    font-weight: 700;
    font-size: 32px;
    margin-top: 12px;
  }
  .img-2 {
    position: relative;
    /* aspect-ratio: 9.09; */
    object-fit: auto;
    object-position: center;
    width: 445px;
    margin-top: 18px;
    max-width: 100%;
  }
  .div-9 {
    position: relative;
    text-align: center;
    margin-top: 31px;
    font: 700 96px Inter, sans-serif;
  }

  .div-10 {
    position: relative;
    align-self: start;
    display: flex;
    gap: 20px;
    font-size: 64px;
    font-weight: 700;
    white-space: nowrap;
    text-align: center;
    margin: 108px 0 0 33px;
  }

  .div-11 {
    background-color: #d9d9d9;
    width: 120px;
    height: 120px;
  }
  .div-12 {
    font-family: Inter, sans-serif;
    flex-grow: 1;
    flex-basis: auto;
    margin: auto 0;
  }

  .img-3 {
    position: relative;
    /* aspect-ratio: 6.67; */
    object-fit: auto;
    object-position: center;
    width: 100%;
    align-self: stretch;
    margin-top: 20px;
  }
</style>
</head>
<body>
<div class="div">
  <img
    loading="lazy"
    srcset="assets/bg.png"
    class="img"
  />
  <div class="div-2">
    <div class="div-3">
      <div class="div-4">28 JULI 2024</div>
      <div class="div-5">HOTEL DAFAM SEMARANG</div>
    </div>
    <div class="div-6">
      <div class="div-7">FUN RUN 6K</div>
      <div class="div-8">LARI ANTAR GENG</div>
    </div>
  </div>
  <img
    loading="lazy"
    srcset="assets/sponsor-atas.png"
    class="img-2"
  />
  <div class="div-9">
    NAME
    <br />
    GROUP
  </div>
  <div class="div-10">
    <div class="div-11"></div>
    <div class="div-12">001</div>
  </div>
  <img
    loading="lazy"
    srcset="assets/sponsor-bawah.png"
    class="img-3"
  />
</div>
</body>
</html>