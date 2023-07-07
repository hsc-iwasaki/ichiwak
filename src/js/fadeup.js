import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

export default function () {
  gsap.registerPlugin(ScrollTrigger);
  gsap.utils.toArray(".fadeup").forEach((el) => {
    let figureEl = el.querySelector("figure");
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
        el,
        {
          css: { filter: "blur(10px)", opacity: 0, y: 10 },
        },
        {
          opacity: 1,
          css: { filter: "blur(0px)", opacity: 1, y: 0 },
          duration: 0.8,
          ease: "Power4.out",
        }
      )
      .to(
        figureEl,
        {
          "--polygon": "0% 0%, 100% 0%, 100% 100%, 0 100%",
          ease: "power4.out",
          duration: 1.5,
        },
        "-=0.4"
      );
  });
}
