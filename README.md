HunanHR
=======

a symfony2 project - hunanhr.com

湖南英才网 hunanhr.com 网站源码

安装

git clone https://github.com/wenmingtang/HunanHR.git

cp app/config/parameters.yml.dist app/config/parameters.yml

vim app/config/parameters.yml

设置数据库用户名和库名后

php app/console doctrine:database:create
php app/console doctrine:schema:create
php app/console hr:acl:installAces

就可以访问你的安装地址测试了。

全文检索依赖 elasticsearch，这个需要先行安装，如果是测试环境用，推荐 https://github.com/medcl/elasticsearch-rtf

如果需要使用oauth登录，请在 app/config/config.yml 中设置新浪微博、QQ链接的 [client_id], [client_secret] 相关信息。
