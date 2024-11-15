const { trim } = require("lodash");

(function ($) {
  "use strict";
  $(function () {
    let servers = JSON.parse($("#servers").text());
    let options = JSON.parse($("#options").text());
    let map = null;

    let resultsFetched = 0;

    $(document).ready(function () {
      let hashes = getHash();
      if (!jQuery.isEmptyObject(hashes)) {
        $("#type").val(hashes.type);
        $("#domain").val(hashes.domain);
        $("#input input[type=submit]").val(". . .");
        $("#input input[type=submit]").attr("disabled", true);
        for (let i = 0; i < servers.length; i++) {
          getResults(i, servers[i].id, hashes.type, hashes.domain);
        }
      }
    });

    if ($("#map").length > 0) {
      $("#map").vectorMap({
        map: "world_mill",
        zoomOnScroll: !1,
        zoomButtons: !1,
        normalizeFunction: "polynomial",
        hoverOpacity: 0.7,
        hoverColor: false,
        markerStyle: {
          initial: {
            fill: "#FFF",
            stroke: "#FFF",
          },
        },
        backgroundColor: "transparent",
        regionStyle: {
          initial: {
            fill: options["colors"]["primary"],
            stroke: options["colors"]["primary"],
            "stroke-width": 1,
            "stroke-opacity": 1,
          },
          hover: {
            "fill-opacity": 1,
            cursor: "default",
          },
        },
        markers: servers.map(function (s) {
          return { name: s.name, latLng: [s.lat, s.long] };
        }),
        onMarkerTipShow: function (e, el, index) {
          var html = '<div class="name"><img width="16px" src="/images/flags/' + servers[index].country.toLowerCase() + '.svg"> ' + servers[index].name + "</div>";
          servers[index].result && (html += '<div class="result">' + servers[index].result + "</div>"), el.html(html);
        },
        onRegionTipShow: function (e) {
          e.preventDefault();
        },
      });
      map = $("#map").vectorMap("get", "mapObject");
      clearResults();
    }

    $("#input").on("submit", (e) => {
      e.preventDefault();
      clearResults();
      $("#input input[type=submit]").val(". . .");
      $("#input input[type=submit]").attr("disabled", true);
      let expected = $("#expected").val();
      let domain = $("#domain").val();
      domain = domain.replace("http://", "").replace("https://", "").split(/[/?#]/)[0];
      $("#domain").val(domain);
      let type = $("#type").val();
      setHash(domain, type);
      for (let i = 0; i < servers.length; i++) {
        getResults(i, servers[i].id, type, domain, expected);
      }
      map.reset();
    });

    function getResults(key, id, type, domain, expected) {
      $.ajax({
        url: `fetch/${domain}/${type}/${id}`,
        type: "POST",
        data: {
          _token: document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
        },
        success: function (data) {
          if (data) {
            $("#server-" + id + " .result").html(data);
            servers[key].result = data;
            if (map) {
              if (expected != undefined && expected != "" && expected != data) {
                $("#server-" + id + " .status img").attr("src", errorImg);
                map.markers[key].element.config.style.current.image = errorImg;
              } else {
                $("#server-" + id + " .status img").attr("src", successImg);
                map.markers[key].element.config.style.current.image = successImg;
              }
            }
          } else {
            $("#server-" + id + " .status img").attr("src", errorImg);
            servers[key].result = "";
            if (map) {
              map.markers[key].element.config.style.current.image = errorImg;
            }
          }
          resultsFetched++;
          map.reset();
          if (resultsFetched === servers.length) {
            $("#input input[type=submit]").val("Find");
            $("#input input[type=submit]").removeAttr("disabled");
          }
        },
        error: function (data) {
          console.error(`Error on: ${servers[key].name} with message ${data}`);
          $("#server-" + id + " .status img").attr("src", errorImg);
          if (map) {
            map.markers[key].element.config.style.current.image = errorImg;
          }
          resultsFetched++;
          map.reset();
          if (resultsFetched === servers.length) {
            $("#input input[type=submit]").val(options.find_btn.text);
            $("#input input[type=submit]").removeAttr("disabled");
          }
        },
        timeout: options["timeout"] ? options["timeout"] * 1000 : 5000,
      });
    }

    function clearResults() {
      resultsFetched = 0;
      for (let i = 0; i < servers.length; i++) {
        $("#server-" + servers[i].id + " .result").html("");
        $("#server-" + servers[i].id + " .status img").attr("src", pendingImg);
        if (map) {
          map.markers[i].element.config.style.current.image = pendingImg;
        }
        map.reset();
      }
    }

    function setHash(domain, type) {
      location.hash = `#/${type}/${domain}`;
    }

    function getHash() {
      const hashes = location.hash.split("/");
      if (hashes[2] !== undefined && hashes[1] !== undefined) {
        return {
          domain: hashes[2],
          type: hashes[1],
        };
      } else {
        return {};
      }
    }
  });
})(jQuery);

//Reload if 100 minutes are passed
let start = new Date();
setInterval(() => {
  if ((new Date() - start) / (1000 * 60) > 100) {
    location.reload();
  }
}, 1000);

if (typeof Shortcode !== "undefined") {
  new Shortcode(document.querySelector("body"), {
    blogs: function () {
      var data = '<div class="blogs row">';
      var fetchUrl = this.options.url + "/wp-json/wp/v2/posts?_fields[]=link&_fields[]=title&_fields[]=excerpt";
      var filters = {
        context: this.options.context,
        page: this.options.page,
        per_page: this.options.per_page,
        search: this.options.search,
        after: this.options.after,
        author: this.options.author,
        author_exclude: this.options.author_exclude,
        before: this.options.before,
        exclude: this.options.exclude,
        include: this.options.include,
        offset: this.options.offset,
        order: this.options.order,
        orderby: this.options.orderby,
        slug: this.options.slug,
        status: this.options.status,
        categories: this.options.categories,
        categories_exclude: this.options.categories_exclude,
        tags: this.options.tags,
        tags_exclude: this.options.tags_exclude,
        sticky: this.options.sticky,
      };
      Object.keys(filters).forEach(function (key) {
        if (filters[key]) {
          fetchUrl += "&" + key + "=" + filters[key];
        }
      });
      fetch(fetchUrl)
        .then((response) => response.json())
        .then((blogs) => {
          blogs.forEach(function (item) {
            data += '<div class="blog-item col-md-6">';
            data += '<a href="' + item.link + '" target="_blank">';
            data += '<span class="title">' + item.title.rendered + "</span>";
            data += '<span class="excerpt">' + item.excerpt.rendered + "</span>";
            data += "</a>";
            data += "</div>";
          });
          data += "</div>";
          if (blogs.length) {
            document.getElementById("blogs").innerHTML = data;
          } else {
            document.getElementById("blogs").innerHTML = '<div class="no-content">204 - NO CONTENT AVAILABLE</div>';
          }
        });
      return "<div id='blogs'><div class='content-loader'><div class='spinner-border' role='status'><span class='sr-only'>Loading...</span></div></div>";
    },
    html: function () {
      let txt = document.createElement("textarea");
      txt.innerHTML = this.contents;
      return txt.value;
    },
  });
}

document.querySelectorAll("#blacklist form").forEach((el) => {
  el.addEventListener("submit", (e) => {
    e.preventDefault();
    location.hash = document.querySelector("#blacklist input[name=input]").value;
    checkBlacklist();
  });
});

function checkBlacklist() {
  let current = 0;
  document.querySelector("#blacklist form input[type=submit]").disabled = true;
  const input = document.querySelector("#blacklist input[name=input]").value;
  if (trim(input)) {
    document.querySelector("#blacklist-results .row").innerHTML = '<div class="col-12 text-center mt-3"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';
    axios.post(`/domain/ip/${input}`).then((response) => {
      if (response.data) {
        const ip = response.data;
        if (ip) {
          console.log(blacklists);
          document.querySelector("#blacklist-results .row").innerHTML = "";
          blacklists.forEach((blacklist) => {
            axios
              .post("/blacklist", {
                ip,
                blacklist,
              })
              .then((response) => {
                current++;
                document.querySelector("#blacklist form input[type=submit]").value = `Checking (${current}/${blacklists.length})`;
                let listed = response.data ? true : false;
                let icon = "fa-check-circle text-success";
                let label_css = "bg-success";
                let label = "Not Listed";
                if (listed) {
                  icon = "fa-times-circle text-danger";
                  label_css = "bg-danger";
                  label = "Listed";
                }
                document.querySelector("#blacklist-results .row").insertAdjacentHTML(
                  "beforeend",
                  `<div class="col-12 col-lg-6 col-xl-4 mt-2">
                        <div class="border rounded p-2">
                            <div class="row">
                                <div class="col-8 d-flex align-items-center gap-5">
                                    <i class="fas ${icon} ml-1"></i>
                                    <div>${blacklist}</div>
                                </div>
                                <div class="col-4 text-right">
                                    <small class="${label_css} text-white px-2 py-1 rounded">${label}</small>
                                </div>
                            </div>
                        </div>
                    </div>`
                );
              })
              .finally(() => {
                if (current == blacklists.length) {
                  document.querySelector("#blacklist form input[type=submit]").disabled = false;
                  document.querySelector("#blacklist form input[type=submit]").value = document.querySelector("#blacklist form input[type=submit]").dataset.value;
                }
              });
          });
        } else {
          document.querySelector("#blacklist-results .row").innerHTML = '<div class="col-12 text-center">Invalid Input. Please try again!</div>';
        }
      }
    });
  }
}

document.querySelectorAll("#dmarc form").forEach((el) => {
  el.addEventListener("submit", (e) => {
    e.preventDefault();
    location.hash = document.querySelector("#dmarc input[name=input]").value;
    checkDmarc();
  });
});

function checkDmarc() {
  document.querySelector("#dmarc form input[type=submit]").disabled = true;
  const input = document.querySelector("#dmarc input[name=input]").value;
  if (trim(input)) {
    document.querySelector("#dmarc-results").innerHTML = '<div class="row"><div class="col-12 text-center mt-3"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div></div>';
    axios.post(`/dmarc/${input}`).then((response) => {
      document.querySelector("#dmarc form input[type=submit]").disabled = false;
      if (response.data) {
        const records = response.data.split(";");
        if (records.length > 0) {
          let tbody = "";
          for (let i = 0; i < records.length; i++) {
            [type, value] = records[i].split("=");
            tbody += `
                <tr>
                  <th>${type}</th>
                  <td>${value}</td>
                  <td><img src="/${checkValidity(type, value) ? successImg : errorImg}" alt="validity-check"></td>
                  <td>${getDescription(type)}</td>
                </tr>
              `;
          }
          let html = `
              <div class="table-responsive">
                <table class="table table-bordered rounded">
                  <thead>
                    <tr>
                      <th scope="col">Tag</th>
                      <th scope="col">Value</th>
                      <th scope="col">Validity</th>
                      <th scope="col">Description</th>
                    </tr>
                  </thead>
                  <tbody>
                    ${tbody}
                  </tbody>
                </table>
              </div>
            `;
          document.getElementById("dmarc-results").innerHTML = html;
        }
      } else {
        document.querySelector("#dmarc-results").innerHTML = `
            <div class="row">
              <div class="col-12 text-center mt-3">
                <div class="d-flex align-items-center justify-content-center">
                  <img src="/${errorImg}" alt="error">
                  <p class="m-0 ml-2">DMARC Record Not Found</p>
                </div>
              </div>
            </div>
          `;
      }
    });
  }
}

function getDescription(type) {
  type = type.trim();
  const tags = JSON.parse('{"v":{"description":"Version of the DMARC protocol being used","example":"v=DMARC1"},"p":{"description":"Policy to be applied by the receiving mail server","example":"p=quarantine","possible_values":["none","quarantine","reject"]},"rua":{"description":"URI where aggregate feedback reports should be sent","example":"rua=mailto:aggrep@example.com"},"ruf":{"description":"URI where forensic (failure) reports should be sent","example":"ruf=mailto:forensic@example.com"},"sp":{"description":"Override policy for subdomains","example":"sp=reject","possible_values":["none","quarantine","reject"]},"adkim":{"description":"Alignment mode for DKIM (DomainKeys Identified Mail)","example":"adkim=r","possible_values":["r","s"]},"aspf":{"description":"Alignment mode for SPF (Sender Policy Framework)","example":"aspf=s","possible_values":["r","s"]},"pct":{"description":"Percentage of messages to which the DMARC policy is applied","example":"pct=100"},"fo":{"description":"Failure options for DMARC failures","example":"fo=1","possible_values":["0","1","d"]},"rf":{"description":"Report format for feedback reports","example":"rf=afrf","possible_values":["afrf","iodef"]},"ri":{"description":"Request to receivers to generate aggregate reports separated by no more than the requested number of seconds.","example":"ri=86400"}}');
  if (tags[type]) {
    return tags[type].description;
  }
}

function checkValidity(type, value) {
  type = type.trim();
  value = value.toLowerCase().trim();
  switch (type) {
    case "v":
      return value == "dmarc1";
    case "p":
      return ["none", "quarantine", "reject"].includes(value);
    case "sp":
      return ["none", "quarantine", "reject"].includes(value);
    case "adkim":
      return ["r", "s"].includes(value);
    case "aspf":
      return ["r", "s"].includes(value);
    case "pct":
      return parseInt(value) >= 0 && parseInt(value) <= 100;
    case "fo":
      return ["0", "1", "d"].includes(value);
    case "rf":
      return ["afrf", "iodef"].includes(value);
    case "rua":
      return isValidUri(value);
    case "ruf":
      return isValidUri(value);
    case "ri":
      return parseInt(value) >= 0 && parseInt(value) <= 4294967295;
  }
  return false;
}

function isValidUri(uri) {
  var uriPattern = /^(?:(?:[a-z]+:)?\/\/)?(?:\S+(?::\S*)?@)?(?:(?!-)[A-Za-z0-9-]{1,63}(?:(?:\.(?!-)[A-Za-z0-9-]{1,63})+)?)(?::\d{1,5})?(?:\/|[/?]\S+)?$/;
  return uriPattern.test(uri);
}

if (location.hash) {
  let value = location.hash.replaceAll("#", "");
  if (location.pathname.includes("blacklist")) {
    document.querySelector("#blacklist input[name=input]").value = value;
    checkBlacklist();
  } else if (location.pathname.includes("dmarc")) {
    document.querySelector("#dmarc input[name=input]").value = value;
    checkDmarc();
  }
}
