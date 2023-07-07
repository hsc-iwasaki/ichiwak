import "slick-carousel";
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";
export default function () {
  if (document.querySelector(".job_listings.list")) {
    $(".job_listings.list").slick({
      arrows: false,
      autoplay: true,
      centerMode: true,
      dots: false,
      centerPadding: "20%",
      slidesToShow: 3,
      variableWidth: true,
      responsive: [
        {
          breakpoint: 1200, //ブレイクポイントを指定
          settings: {
            centerPadding: "5%",
          },
        },
        {
          breakpoint: 768, //ブレイクポイントを指定
          settings: {
            slidesToShow: 1,
            centerPadding: "12%",
          },
        },
      ],
    });
  }
}
