SELECT 
	nome,
	COUNT(cl.id)
FROM
	cursante c,
	cursante_licoes cl
WHERE
	c.id = cl.id_cursante
GROUP BY
	cl.id_cursante;
	
SELECT
	c.nome,
	cu.numero,
	cu.unidade,
	cl.ordem,
	CASE
		WHEN cl.id_cursos_licoes_tipo = 1 THEN clt1.pergunta
		WHEN cl.id_cursos_licoes_tipo = 5 THEN clt5.pergunta_desc
		WHEN cl.id_cursos_licoes_tipo = 7 THEN clt7.enunciado
		WHEN cl.id_cursos_licoes_tipo = 8 THEN clt8.vouf_pergunta
	END AS questao,
	CASE
		WHEN cl.id_cursos_licoes_tipo = 1 THEN clt1.resposta_certa
		WHEN cl.id_cursos_licoes_tipo = 5 THEN ""
		WHEN cl.id_cursos_licoes_tipo = 7 THEN CONCAT_WS(",", clt7.colB1, clt7.colB2, clt7.colB3, clt7.colB4, clt7.colB5)
		WHEN cl.id_cursos_licoes_tipo = 8 THEN clt8.vouf
	END AS resposta_certa,
	cul.feita_em,
	cul.resposta
FROM
	cursante_licoes cul,
	cursante c,
	cursos_unidades cu,
	cursos_licoes cl
	LEFT JOIN cursos_licoes_tipo_1 clt1 ON clt1.id_cursos_licoes = cl.id
	LEFT JOIN cursos_licoes_tipo_5 clt5 ON clt5.id_cursos_licoes = cl.id
	LEFT JOIN cursos_licoes_tipo_7 clt7 ON clt7.id_cursos_licoes = cl.id
	LEFT JOIN cursos_licoes_tipo_8 clt8 ON clt8.id_cursos_licoes = cl.id
WHERE
	cu.id_curso = 1
	AND cu.id = cl.id_cursos_unidades
	AND cl.id_cursos_licoes_tipo IN (1,5,7,8)
	AND cul.id_licao = cl.id
	AND cul.id_cursante = c.id
ORDER BY
	c.nome ASC,
	cu.numero ASC,
	cl.ordem ASC;
	

SELECT
	c.nome,
	cl.id,
	cl.titulo,
	cul.resposta,
	cul.feita_em	
FROM
	cursante c,
	cursante_licoes cul,
	cursos_licoes cl
WHERE
	c.id = cul.id_cursante
	AND cl.id = cul.id_licao
	AND c.id = '02adb2b2-5476-11f1-8c16-566fe141019e'
	
	
	
	