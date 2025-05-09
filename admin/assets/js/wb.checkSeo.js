var WBSeoClass = function () {
    // default data
    this.default_data = {
        title: '',
        description: '',
        content: '',
        seo_title: '',
        seo_keyword: '',
        seo_description: '',
        url: '',
        heading: '',
        heading_description: ''
    };
    this.result = {};
    this.default_config = {
        detail_page: {
            min_keyword_ratio_in_sentence : 0.001,
            title: {
                keyword_ratio: [{
                    from: 0,
                    //to: 0.99,
                    to: 0.009,
                    status: 'too_few'
                },{
                    from: 0.01,
                    to: 1000,
                    is_pass: false,
                    status: 'good'
                }]
            },
            description: {
                keyword_ratio: [{
                    from: 0,
                    //to: 0.99,
                    to: 0,
                    //status: 'few'
                    status: 'too_few'
                }, {
                    //from: 1,
                    from: 0.01,
                    to: 1000,
                    status: 'good'
                }],
                recommended_keyword_appear_time: {
                    min: 1,
                    max: 1
                }
            },
            content: {
                keyword_ratio: [{
                    from: 0,
                    //to: 0.009999,
                    to: 0,
                    status: 'too_few'
                }, {
                    //from: 0.01,
                    from: 0.001,
                    to: 0.029999,
                    status: 'good'//'few'
                }, {
                    from: 0.03,
                    to: 0.069999,
                    status: 'good'
                }, {
                    from: 0.07,
                    to: 0.089999,
                    status: 'good'
                }, {
                    from: 0.09,
                    to: 1,
                    status: 'good'
                }]
            },
            seo_keywords: {
                range_of_words: [{
                    from: 0,
                    to: 100,
                    is_pass: true,
                    status: 'good'
                }]
            },
            seo_title: {
                maximum_words: 70,
                keyword_ratio: [{
                    from: 0,
                    //to: 0.99,
                    to: 0.009,
                    //status: 'few'
                    status: 'too_few'
                }, {
                    //from: 1,
                    from: 0.01,
                    to: 1000,
                    status: 'good'
                }]
            },
            seo_description: {
                maximum_words: 160,
                keyword_ratio: [{
                    from: 0,
                    //to: 0.089,
                    to: 0,
                    status: 'too_few'
                }, {
                    //from: 0.09,
                    from: 0.01,
                    to: 0.149,
                    //status: 'few'
                    status: 'good'
                }, {
                    from: 0.15,
                    to: 0.199,
                    status: 'good'
                }, {
                    from: 0.2,
                    to: 0.279,
                    status: 'good'
                }, {
                    from: 0.28,
                    to: 1,
                    status: 'good'
                }]
            },
            url: {
                keyword_ratio: [{
                    from: 0.8,
                    to: 1000,
                    status: 'good'
                }, {
                    //from: 0.6,
                    from: 0.0001,
                    to: 0.79,
                    status: 'good'
                }, {
                    from: 0,
                    //to: 0.59,
                    to: 0,
                    //status: 'too_few'
                    status: 'too_few'
                }]
            }
        },
        menu_page: {
            min_keyword_ratio_in_sentence : 0.001,
            title: {
                keyword_ratio: [{
                    from: 0,
                    to: 1000,
                    status: 'good'
                }]
            },
            heading: {
                keyword_ratio: [{
                    from: 0,
                    //to: 0.59,
                    to: 0,
                    status: 'too_few'
                }, {
                    //from: 0.6,
                    from: 0.01,
                    to: 0.79,
                    status: 'good'
                }, {
                    from: 0.8,
                    to: 1,
                    status: 'good'
                }, {
                    from: 1.01,
                    to: 9999,
                    status: 'good'
                }]
            },
            description: {
                keyword_ratio: [{
                    from: 0,
                    to: 0.99,
                    status: 'good'
                }, {
                    from: 1,
                    to: 1000,
                    status: 'good'
                }]
            },
            seo_title: {
                maximum_words: 70,
                keyword_ratio: [{
                    from: 0,
                    //to: 0.59,
                    to: 0,
                    status: 'too_few'
                }, {
                    //from: 0.6,
                    from: 0.01,
                    to: 0.79,
                    status: 'good'
                }, {
                    from: 0.8,
                    to: 1,
                    status: 'good'
                }]
            },
            seo_description: {
                maximum_words: 160,
                keyword_ratio: [{
                    from: 0,
                    //to: 0.149,
                    to: 0,
                    status: 'too_few'
                }, {
                    //from: 0.15,
                    from: 0.01,
                    to: 0.249,
                    status: 'good'
                }, {
                    from: 0.25,
                    to: 0.349,
                    status: 'good'
                }, {
                    from: 0.35,
                    to: 0.449,
                    status: 'good'
                }, {
                    from: 0.45,
                    to: 1,
                    status: 'good'
                }],
            },
            heading_description: {
                maximum_words: 160,
                keyword_ratio: [{
                    from: 0,
                    //to: 0.149,
                    to: 0,
                    status: 'too_few'
                }, {
                    //from: 0.15,
                    from: 0.01,
                    to: 0.249,
                    status: 'good'
                }, {
                    from: 0.25,
                    to: 0.349,
                    status: 'good',
                    message: 'Bạn làm rất chuẩn'
                }, {
                    from: 0.35,
                    to: 0.449,
                    status: 'good'
                }, {
                    from: 0.45,
                    to: 1,
                    status: 'good'
                }],
            },
            seo_keywords: {
                range_of_words: [{
                    from: 0,
                    //to: 4,
                    to: 0,
                    is_pass: false,
                    status: 'too_few'
                }, {
                    //from: 4,
                    from: 0.01,
                    to: 11,
                    is_pass: true,
                    status: 'good'
                }, {
                    from: 11,
                    to: 10000,
                    is_pass: false,
                    status: 'good'
                }]
            },
            url: {
                keyword_ratio: [{
                    from: 0.8,
                    to: 1,
                    status: 'good'
                }, {
                    //from: 0.6,
                    from: 0.01,
                    to: 0.79,
                    status: 'good'
                }, {
                    from: 0,
                    //to: 0.59,
                    to: 0,
                    status: 'too_few'
                }]
            }
        }
    };
    this.message = {
        too_few: {
            text: 'Bạn rải từ khóa quá ít, cần rải thêm.',
            class: 'text-danger'
        },
        few: {
            text: 'Bạn rải từ khóa hơi ít, nên rải thêm nhé',
            class: 'text-warning'
        },
        good: {
            text: 'Bạn làm rất chuẩn',
            class: 'text-success'
        },
        many: {
            text: 'Bạn rải từ khóa hơi nhiều, nên giảm bớt lại nhé',
            class: 'text-warning'
        },
        too_many: {
            text: 'Bạn rải từ khóa quá nhiều, cần giảm bớt lại',
            class: 'text-danger'
        },
        keyword_must_be_the_same: {
            text: 'Keyword phải gồm 2 từ có dấu và không dấu giống nhau',
            class: 'text-danger'
        },
        too_short_keyword: {
            text: 'Keyword quá ngắn, keyword chuẩn nên dài từ 4 ~ 10 từ bạn nhé',
            class: 'text-danger'
        },
        too_long_keyword: {
            text: 'Keyword quá dài, keyword chuẩn nên dài từ 4 ~ 10 từ bạn nhé',
            class: 'text-danger'
        },
        keyword_must_not_empty: {
            text: 'Keyword không được để trống',
            class: 'text-danger'
        },
        bad_keyword_length: {
            text: 'Keyword phải có độ dài từ 4 ~ 10 từ',
            class: 'text-danger'
        },
        empty_content: {
            text: 'Nội dung trống, không thể check chuẩn seo',
            class: 'text-danger'
        },
        warning: {
            text: 'Bạn làm gần tốt',
            class: 'text-warning'
        },
        bad: {
            text: 'Bạn cần tối ưu lại',
            class: 'text-danger'
        },
        empty: {
            text: 'Phần này không được để trống',
            class: 'text-danger'
        }
    };
};
WBSeoClass.prototype = {
    /*
     * Check seo
     */
    REGEX_SPLIT_KEYWORD: /[,;:!?.()\"\...]+/,
    REGEX_SPLIT_SENTENCE: /[,;!?.\n\...]+/,
    REGEX_SPLIT_WORD: /[\s,]+/,
    REGEX_REMOVE_SYMBOL: /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi,

    setFinalResult: function (result) {
        Object.assign(this.result, result);
    },

    checkSeoMenuPage: function (data) {
        this.config = this.default_config.menu_page;
        this.data = Object.assign(this.default_data, data);
        let _this = this;
        return this.checkSeoKeyword()
            .then(function () {
                _this.checkMenuHeading();
                _this.checkMenuHeadingDescription();
                _this.checkSeoTitle();
                _this.checkSeoUrl();
                _this.checkSeoDescription();
                return _this.parseResult();
            })
            .catch(function (error) {
                return _this.parseResult();
            });
    },
    checkSeoDetailPage: function (data) {
        this.config = this.default_config.detail_page;
        this.data = Object.assign(this.default_data, data);
        let _this = this;
        return this.checkSeoKeyword()
            .then(function () {
                _this.checkDocumentTitle();
                if(page_type !== 'landingpage' && page_type !== 'contact') {
                    _this.checkDocumentDescription();
                }
                if(page_type !== 'homepage') {
                    if(page_type !== 'landingpage' && page_type !== 'contact') {
                        _this.checkDocumentContent();
                    }
                    _this.checkSeoUrl();
                }
                _this.checkSeoTitle();
                _this.checkSeoDescription();
                return _this.parseResult();
            })
            .catch(function (error) {
                return _this.parseResult();
            });
    },

    parseResult: function () {
        let _this = this;
        let result = {};
        let final_status = "good";
        Object.keys(this.result).forEach(function (key) {
            let status = _this.result[key].status;
            //if(_this.message[status]){
                let html_result = '<span class="'+_this.message[status].class+' seo_result">'+_this.message[status].text+'</span>';
                result[key] = html_result;
                if (_this.message[status].class == 'text-danger') {
                    final_status = "bad";
                } else if (_this.message[status].class == 'text-warning' && final_status != 'bad') {
                    final_status = "warning";
                }
           // }

        });
        result["final_result"] = '<span class="'+_this.message[final_status].class+' seo_result pull-right">'+_this.message[final_status].text+'</span>';
        return result;
    },
    checkDocumentTitle: function () {
        let keyword = this.data.seo_keyword[0];

        if (this.data.title == null) {
            this.setFinalResult({
                title: {
                    status: 'good'
                }
            });
            return;
        }
        let title = this.normalizeContent(this.data.title);

        if (title.length == 0) {
            this.setFinalResult({
                title: {
                    status: 'empty',
                }
            });
            return; 
        }
        let keyword_appearance_ratio = this.calculateAppearanceRatio(keyword, title);
        let keyword_ratio_range = this.config.title.keyword_ratio;
        for (let i = 0; i < keyword_ratio_range.length; i++) {
            let range = keyword_ratio_range[i];
            if (this.inRange(range, keyword_appearance_ratio)) {
                this.setFinalResult({
                    title: {
                        status: range.status,
                    }
                });
                return; 
            }
        }
    },
    checkMenuHeading: function () {
        let keyword = this.data.seo_keyword[0];
        if (this.data.heading == null) {
            this.setFinalResult({
                heading: {
                    status: 'good'
                }
            });
            return; 
        }
        let heading = this.normalizeContent(this.data.heading);
        if (heading.length == 0) {
            this.setFinalResult({
                heading: {
                    status: 'empty',
                }
            });
            return; 
        }
        let keyword_appearance_ratio = this.calculateAppearanceRatio(keyword, heading);
        let keyword_ratio_range = this.config.heading.keyword_ratio;
        for (let i = 0; i < keyword_ratio_range.length; i++) {
            let range = keyword_ratio_range[i];
            if (this.inRange(range, keyword_appearance_ratio)) {
                this.setFinalResult({
                    heading: {
                        status: range.status,
                    }
                });
                return; 
            }
        }
    },
    checkMenuHeadingDescription: function () {
        if (this.data.heading_description == null) {
            this.setFinalResult({
                heading_description: {
                    status: 'good'
                }
            });
            return; 
        }
        let heading_description = this.normalizeContent(this.data.heading_description);
        if (heading_description.length == 0) {
            this.setFinalResult({
                heading_description: {
                    status: 'empty',
                }
            });
            return;
        }
        let keyword = this.data.seo_keyword[0];
        let arr_sentences = this.splitContentToSentence(heading_description);
        let heading_description_length = this.countWords(heading_description);
        let keyword_length = this.countWords(keyword);
        let num_of_words_of_keyword_in_content = 0;
       
        arr_sentences = this.removeSortSentence(arr_sentences);

        for (let i = 0; i < arr_sentences.length; i++) {
            let keyword_appearance_ratio = this.calculateAppearanceRatio(keyword, arr_sentences[i]);
            if (keyword_appearance_ratio > 0.8) {
                this.setFinalResult({
                    heading_description: {
                        status: 'good'
                    }
                });
                return;
            }
        }
        this.setFinalResult({
            heading_description: {
                status: 'few'
            }
        });
    },
    checkDocumentDescription: function (set_final_result = true) {
        if (this.data.description == null) {  
            this.setFinalResult({
                description: {
                    status: 'good'
                }
            });
            return; 
        }
        let description = this.normalizeContent(this.data.description);
        if (description.length == 0) {
            this.setFinalResult({
                description: {
                    status: 'empty',
                }
            });
            return;
        }
        let keyword = this.data.seo_keyword[0];
        let total_appearance_time = 0;
        let keyword_ratio_range = this.config.description.keyword_ratio;
        let arr_sentences = this.splitContentToSentence(description);
        //arr_sentences = this.removeSortSentence(arr_sentences);
        for (let i = 0; i < arr_sentences.length; i++) {
            let keyword_appearance_ratio = this.calculateAppearanceRatio(keyword, arr_sentences[i]);
            //if (keyword_appearance_ratio > 0.8) {
            if (keyword_appearance_ratio > 0) {
                this.setFinalResult({
                    description: {
                        status: 'good'
                    }
                });
                return;
            }
        }
        this.setFinalResult({
            description: {
                status: 'too_few'
            }
        });
        return true;
    },

    checkDocumentContent: function () {
        if (this.data.content == null) {  
            this.setFinalResult({
                heading: {
                    content: 'good'
                }
            });
            return;
        }
        let content = this.normalizeContent(this.data.content);
        if (content.length == 0) {
            this.setFinalResult({
                content: {
                    status: "empty",
                }
            });
            return;
        }

        let num_of_words_in_content = this.countWords(content);
        let content_sentences = this.splitContentToSentence(content);
        //content_sentences = this.removeSortSentence(content_sentences);
        let description = this.normalizeContent(this.data.description);
        let num_of_words_in_description = this.countWords(description);
        let description_sentences = this.splitContentToSentence(description);
        let keyword = this.data.seo_keyword[0];
        let keyword_length = this.countWords(keyword);
        let keyword_ratio = 0;
        let total_words = num_of_words_in_content + num_of_words_in_description;
        let num_of_keyword_appearance_in_description = 0;

        if (num_of_words_in_description == 0) {
            this.setFinalResult({
                content: {
                    status: "empty_content",
                }
            });
            return;
        }

        for (let i = 0; i < description_sentences.length; i++) {
            if(this.calculateNumOfKeywordInSentence(keyword, description_sentences[i]) > 0) {
                num_of_keyword_appearance_in_description ++;
            }
        }

        let num_of_keyword_appearance_in_content = 0;
        for (let i = 0; i < content_sentences.length; i++) {
            num_of_keyword_appearance_in_content += this.calculateNumOfKeywordInSentence(keyword, content_sentences[i])/keyword_length;
        }
        let keyword_ratio_range = this.config.content.keyword_ratio;
        let total_appearance_time = num_of_keyword_appearance_in_content + num_of_keyword_appearance_in_description;
        let recommendedKeywordAppearTime = (total_words / (20 * keyword_length)) - 1;
        //showRecommendedKeywordAppearTime(Math.round(recommendedKeywordAppearTime));
        if (num_of_keyword_appearance_in_content == 0) {
            this.setFinalResult({
                content: {
                    status: "too_few",
                }
            });
            return;
        }

        keyword_ratio = (total_appearance_time * keyword_length)/total_words;

        for (let j = 0; j < keyword_ratio_range.length; j++) {
            let range = keyword_ratio_range[j];
            if (this.inRange(range, keyword_ratio)) {
                this.setFinalResult({
                    content: {
                        status: range.status,
                    }
                });
                return;
            }
        }
    },

    checkSeoTitle: function () {
        if (this.data.seo_title == null) {
            this.setFinalResult({
                seo_title: {
                    status: 'good'
                }
            });
            return; 
        }
        let seo_title = this.normalizeContent(this.data.seo_title);
        if (seo_title.length == 0) {
            this.setFinalResult({
                seo_title: {
                    status: 'empty',
                }
            });
            return;
        }
        let keyword = this.data.seo_keyword[0];
        let keyword_ratio_range = this.config.seo_title.keyword_ratio;
        let keyword_appearance_ratio = this.calculateAppearanceRatio(keyword, seo_title);

        for (let j = 0; j < keyword_ratio_range.length; j++) {
            let range = keyword_ratio_range[j];
            if (this.inRange(range, keyword_appearance_ratio)) {
                this.setFinalResult({
                    seo_title: {
                        status: range.status,
                    }
                });
                return;
            }
        }
    },

    checkSeoUrl: function () {
        if (this.data.url == null) {
            this.setFinalResult({
                url: {
                    status: 'good'
                }
            });
            return; 
        }
        let url = this.normalizeContent(this.data.url);
        if (url.length == 0) {
            this.setFinalResult({
                url: {
                    status: 'empty',
                }
            });
            return;
        }
        url = this.splitUrlToSentence(url);
        let keyword = this.data.seo_keyword[0];
        keyword = this.removeAccent(keyword);
        let keyword_ratio_range = this.config.url.keyword_ratio;
        let keyword_appearance_ratio = this.calculateAppearanceRatio(keyword, url);
        for (let j = 0; j < keyword_ratio_range.length; j++) {
            let range = keyword_ratio_range[j];
            if (this.inRange(range, keyword_appearance_ratio)) {
                this.setFinalResult({
                    url: {
                        status: range.status,
                    }
                });
                return;
            }
        }
    },
    checkSeoDescription: function () {
        if (this.data.seo_description == null) {
            this.setFinalResult({
                seo_description: {
                    status: 'good'
                }
            });
            return; 
        }
        let seo_description = this.normalizeContent(this.data.seo_description);
        if (seo_description.length == 0) {
            this.setFinalResult({
                seo_description: {
                    status: 'empty',
                }
            });
            return;
        }
        let keyword = this.data.seo_keyword[0];
        let arr_sentences = this.splitContentToSentence(seo_description);
        let seo_description_length = this.countWords(seo_description);
        let keyword_length = this.countWords(keyword);
        let num_of_words_of_keyword_in_content = 0;
       
        //arr_sentences = this.removeSortSentence(arr_sentences);

        for (let i = 0; i < arr_sentences.length; i++) {
            let num_of_words_of_keyword_in_sentence = this.calculateNumOfKeywordInSentence(keyword, arr_sentences[i]);
            num_of_words_of_keyword_in_content += num_of_words_of_keyword_in_sentence;
        }

        //if (num_of_words_of_keyword_in_content >= keyword_length) {
        if (num_of_words_of_keyword_in_content >= keyword_length) {
            this.setFinalResult({
                seo_description: {
                    status: 'good'
                }
            });
        } else {
            this.setFinalResult({
                seo_description: {
                    status: 'few'
                    //status: 'good'
                }
            });
        }
        return;
        
        let keyword_ratio_in_content = num_of_words_of_keyword_in_content / seo_description_length;
        let keyword_ratio_range = this.config.seo_description.keyword_ratio;
        for (let j = 0; j < keyword_ratio_range.length; j++) {
            let range = keyword_ratio_range[j];
            if (this.inRange(range, keyword_ratio_in_content)) {
                this.setFinalResult({
                    seo_description: {
                        status: range.status,
                    }
                });
                return;
            }
        }
    },

    checkSeoKeyword: function () {
        return new Promise ((resolve, reject) => {
            let keywords = this.data.seo_keyword;
            let arr_keywords = this.splitContentToKeyword(keywords);

            if (keywords.length == 0) {
                this.setFinalResult({
                    seo_keyword: {
                        status: 'keyword_must_not_empty',
                    }
                });
                return reject("keyword_must_not_empty");
            }
            let keyword = null;
            let recommended_keyword = null;
            let index = 0;
            while(keyword == null && index < arr_keywords.length) {
                let test_keyword = arr_keywords[index];
                let keyword_length = this.countWords(test_keyword);
                let range_of_words = this.config.seo_keywords.range_of_words;
                for (let i = 0; i < range_of_words.length; i++) {
                    let range = range_of_words[i];
                    if (range.from <= keyword_length && keyword_length < range.to) {
                        if (range.is_pass === false) {
                            break;
                        } else {
                            recommended_keyword = test_keyword;
                            let the_other_same_keyword = this.getSameKeywordInTheOthers(recommended_keyword, arr_keywords);
                            if (the_other_same_keyword == null ) {
                                break;
                            } else {
                                let unsigned_keyword = this.removeAccent(recommended_keyword);
                                if (unsigned_keyword == recommended_keyword) {
                                    // this is unsigned keyword, and the other is the signed keyword
                                    keyword = the_other_same_keyword;
                                } else {
                                    keyword = recommended_keyword;
                                }
                            }
                        }
                    }
                }
                index ++;
            }
            if (recommended_keyword == null) {
                // none of keywords is valid, reject
                this.setFinalResult({
                    seo_keyword: {
                        status: 'bad_keyword_length',
                    }
                });
                return reject("bad_keyword_length");
            }
            if (keyword == null) {
                // i still can't find keyword, so i have to use recommended_keyword
                keyword = recommended_keyword;
            }  
            this.data.seo_keyword = [keyword];

            this.setFinalResult({
                seo_keyword: {
                    status: 'good',
                }
            });
            return resolve();
        });
    },

    getSameKeywordInTheOthers: function (keyword, orther_keywords) {
        keyword = keyword.toLowerCase();
        let unsigned_keyword = this.removeAccent(keyword);
        for (let i = 0; i < orther_keywords.length; i++) {
            if (orther_keywords[i] == keyword) {
                continue;
            }
            if(unsigned_keyword == this.removeAccent(orther_keywords[i].toLowerCase())) {
                return orther_keywords[i];
            }
        }
        return null;
    },
    inRange: function (range, value) {
        if (range.from <= value && value <= range.to) {
            return true;
        } else {
            return false;
        }
    },

    inPassedRange: function (range, value) {
        if (range.from <= value && value <= range.to) {
            if (range.is_pass == true) {
                return true;
            } else {
                return false;
            }
        }
    },

    normalizeContent: function(content) {
        let tmp = document.createElement("DIV");
        tmp.innerHTML = content;
        let result = tmp.textContent || tmp.innerText;
        return result.toLowerCase().trim();
    },
    splitContentToSentence: function(content) {
        let sentences = content.split(this.REGEX_SPLIT_SENTENCE);
        for (let i = sentences.length - 1; i >= 0; i--) {
            sentences[i] = sentences[i].trim();
        }
        return sentences;
    },
    splitUrlToSentence: function (url) {
        return url.replace(/(-)/g, ' ');
    },
    splitContentToKeyword: function(content) {
        let sentences = content.split(this.REGEX_SPLIT_KEYWORD);
        for (let i = sentences.length - 1; i >= 0; i--) {
            sentences[i] = sentences[i].trim();
        }
        return sentences;
    },
    removeSortSentence: function(arr_sentences) {
        for (let i = arr_sentences.length - 1; i >= 0; i--) {
            if (this.countWords(arr_sentences[i]) < 3) {
                arr_sentences.splice(i, 1);
            }
        }
        return arr_sentences;
    },
    countWords: function(sentence) {
        return sentence.trim().split(' ').length;
    },
    removeAccent: function(string) {
        return string.replace(/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ|&aacute;|&agrave;|&acirc;|&atilde;)/g, 'a')
            .replace(/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ|&eacute;|&ecirc;)/g, 'e')
            .replace(/(ì|í|ị|ỉ|ĩ|&iacute;|&igrave;)/g, 'i')
            .replace(/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ|&oacute;|&ocirc;|&ograve;)/g, 'o')
            .replace(/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ|&uacute;|&ugrave;)/g, 'u')
            .replace(/(ỳ|ý|ỵ|ỷ|ỹ|&yacute;)/g, 'y').replace(/(đ)/g, 'd')
            .replace(/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ|&Aacute;|&Agrave;|&Acirc;|&Atilde;)/g, 'A')
            .replace(/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ|&Eacute;|&Ecirc;)/g, 'E')
            .replace(/(Ì|Í|Ị|Ỉ|Ĩ|&Iacute;|&Igrave;)/g, 'I')
            .replace(/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ|&Oacute;|&Ocirc;|&Ograve;)/g, 'O')
            .replace(/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ|&Uacute;|&Ugrave;)/g, 'U')
            .replace(/(Ỳ|Ý|Ỵ|Ỷ|Ỹ|&Yacute;)/g, 'Y')
            .replace(/(Đ)/g, 'D')
            .replace(/(&nbsp;)/g, '');
    },
    removeSymbol: function(string) {
        return string.replace(this.REGEX_REMOVE_SYMBOL, "");
    },
    splitContentToWord: function(content) {
        let arr_words = content.split(this.REGEX_SPLIT_WORD);
        for (let i = arr_words.length - 1; i >= 0; i--) {
            arr_words[i] = arr_words[i].trim();
            arr_words[i] = this.removeSymbol(arr_words[i]);
        }
        return arr_words;
    },
    calculateAppearanceRatio: function(string, sentence) {
        let has_word = 0;
        let string_words = this.splitContentToWord(string);
        let sentence_words = this.splitContentToWord(sentence);
        let num_of_appearance = 0;
        let sentence_length = this.countWords(sentence);
        let string_length = string_words.length;
        let total_appearance_ratio = 0;
        let min_keyword_ratio = this.config.min_keyword_ratio_in_sentence;
        // B1: tính số lần tối đa mà keyword có thể xuất hiện trong câu
        //let max_keyword_appear_time = sentence_words.length / ((string_words.length) * min_keyword_ratio);
        let max_keyword_appear_time = 1;

        for (let i = 0; i < max_keyword_appear_time; i++) {
            num_of_appearance = 0;
            // B2: lặp keyword, tính tổng số lần xuất hiện của từng keyword trong câu
            // nếu keyword xuất hiện, xóa keyword đó khỏi câu, tránh lặp lại trong lần xuất hiện tiếp theo
            for (let j = 0; j < string_words.length; j++) {
                if (this.wordInSentence(string_words[j], sentence)) {
                    sentence = sentence.replace(string_words[j], "");
                    num_of_appearance ++ ;
                    has_word++;
                }
            }
            // B3: tính tỉ lệ xuất hiện keyword trong lần hiện tại
            let keyword_ratio = num_of_appearance / string_length;
            total_appearance_ratio += keyword_ratio;// >= min_keyword_ratio ? keyword_ratio : 0;
        }

        return has_word;
        //return total_appearance_ratio;
    },

    wordInSentence: function (word, sentence) {
        word = word.toLowerCase();
        sentence = sentence.toLowerCase();
        return sentence.search(word) >= 0 ? true : false;
    },

    calculateNumOfKeywordInSentence: function (keyword, sentence) {
        let keyword_appearance_ratio_in_sentence = this.calculateAppearanceRatio(keyword, sentence);
        if (keyword_appearance_ratio_in_sentence < this.config.min_keyword_ratio_in_sentence) {
            return 0;
        } else {
            let words_in_keyword = this.splitContentToWord(keyword); 
            return parseInt(words_in_keyword.length * keyword_appearance_ratio_in_sentence);
        }
    },
};
var WBSeo = new WBSeoClass();