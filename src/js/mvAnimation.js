import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

export default function () {
  let el = document.querySelector(".float");
  let title = document.querySelector(".site-content-page-header-inner");
  gsap.registerPlugin(ScrollTrigger);
    gsap
      .timeline({
        scrollTrigger: {
          trigger: el,
          start: "top 65%",
          end: "end 20%",
          toggleActions: "play none none reverse",
        },
      })
      .fromTo(
        title,
        {
          css: { opacity: 0, y: 10 },
        },
        {
          css: { opacity: 1, y: 0 },
          duration: 1,
        }
      )
      .fromTo(
        el.children,
        {
          css: { filter: "blur(10px)", opacity: 0, y: 10 },
        },
        {
          css: { filter: "blur(0px)", opacity: 1, y: 0 },
          stagger: { 
            amount: 0.8,
           }
        }, "-=60%"
      );
}
