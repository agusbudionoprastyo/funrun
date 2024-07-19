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
    min-height: 928px;
    padding-top: 44px;
    align-items: center;
    color: #fff;
  }
  .img {
    position: absolute;
    inset: 0;
    height: 100%;
    width: 100%;
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
  @media (max-width: 991px) {
    .div-2 {
      max-width: 100%;
      flex-wrap: wrap;
    }
  }
  .div-3 {
    display: flex;
    flex-direction: column;
    padding: 0 20px;
  }
  .div-4 {
    font-family: Inter, sans-serif;
    font-weight: 400;
    align-self: center;
  }
  .div-5 {
    font-family: Inter, sans-serif;
    font-weight: 700;
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
    align-self: center;
  }
  .div-8 {
    font-family: Inter, sans-serif;
    font-weight: 700;
    margin-top: 12px;
  }
  .img-2 {
    aspect-ratio: 9.09;
    object-fit: auto;
    object-position: center;
    width: 845px;
    margin-top: 18px;
    max-width: 100%;
  }
  .div-9 {
    position: relative;
    text-align: center;
    margin-top: 31px;
    font: 700 128px Inter, sans-serif;
  }
  @media (max-width: 991px) {
    .div-9 {
      max-width: 100%;
      font-size: 40px;
    }
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
  @media (max-width: 991px) {
    .div-10 {
      font-size: 40px;
      white-space: initial;
      margin: 40px 0 0 10px;
    }
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
  @media (max-width: 991px) {
    .div-12 {
      font-size: 40px;
    }
  }
  .img-3 {
    aspect-ratio: 6.67;
    object-fit: auto;
    object-position: center;
    width: 100%;
    align-self: stretch;
    margin-top: 20px;
  }
  @media (max-width: 991px) {
    .img-3 {
      max-width: 100%;
    }
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