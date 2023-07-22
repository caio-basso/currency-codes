import scrapy

class TableSpider(scrapy.Spider):
    name = 'table-spider'
    start_urls = ['https://pt.wikipedia.org/wiki/ISO_4217']

    def parse(self, response):
        TABLE_SELECTOR = 'table:nth-of-type(3) tbody tr'
        CODE_SELECTOR = 'td[1]//text()'
        NUMBER_SELECTOR = 'td[2]//text()'
        DECIMAL_SELECTOR = 'td[3]//text()'
        CURRENCY_SELECTOR = 'td[4]//a//text()'
        COUNTRY_SELECTOR = 'td[5]//a//text()'
        COUNTRY_FLAG_SELECTOR = 'td[5]//span//span//img/@src'

        for row in response.css(TABLE_SELECTOR):
            code = row.xpath(CODE_SELECTOR).get()
            number = row.xpath(NUMBER_SELECTOR).get()
            decimal = row.xpath(DECIMAL_SELECTOR).get()
            currency = row.xpath(CURRENCY_SELECTOR).get()
            country = row.xpath(COUNTRY_SELECTOR).getall()
            country_flag = row.xpath(COUNTRY_FLAG_SELECTOR).getall()
            currency_locations = []

            for idx, x in enumerate(country_flag):
                 currency_locations.append({"location": country[idx], "icon": x})
            
            if code is not None:
                yield {
                    "code": code,  
                    "number": number,  
                    "decimal": decimal,  
                    "currency": currency,  
                    "currency_locations": currency_locations
                }
